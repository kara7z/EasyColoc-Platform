<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Colocation;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $colocation = $user->activeColocation;

        $categories = $colocation
            ? $colocation->categories()->orderBy('name')->get()->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'color' => $cat->color,
                    'created_at' => $cat->created_at->format('d/m/Y'),
                ];
            })
            : [];

        $canManageCategory = $colocation
            ? $colocation->memberships()
                ->where('user_id', $user->id)
                ->where('role', 'owner')
                ->whereNull('left_at')
                ->exists()
            : false;

        return view('categories.index', compact('categories', 'canManageCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->ensureActiveMemberWithActiveColocation($request);
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $colocation = $this->ensureActiveMemberWithActiveColocation($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        Category::create([
            'colocation_id' => $colocation->id,
            'name' => $validated['name'],
            'color' => $validated['color'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Category $category)
    {
        $colocation = $this->ensureOwnerWithActiveColocation($request);
        $this->ensureCategoryBelongsToColocation($category, $colocation);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $colocation = $this->ensureOwnerWithActiveColocation($request);
        $this->ensureCategoryBelongsToColocation($category, $colocation);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        $colocation = $this->ensureOwnerWithActiveColocation($request);
        $this->ensureCategoryBelongsToColocation($category, $colocation);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }

    private function ensureOwnerWithActiveColocation(Request $request): Colocation
    {
        $colocation = $this->ensureActiveMemberWithActiveColocation($request);
        $user = $request->user();

        $isOwner = $colocation->memberships()
            ->where('user_id', $user->id)
            ->where('role', 'owner')
            ->whereNull('left_at')
            ->exists();

        if (! $isOwner) {
            abort(403, 'Owner access only.');
        }

        return $colocation;
    }

    private function ensureActiveMemberWithActiveColocation(Request $request): Colocation
    {
        $user = $request->user();
        $colocation = $user?->activeColocation;

        if (! $colocation) {
            abort(403, 'Vous devez avoir une colocation active.');
        }

        if ($colocation->status === 'cancelled') {
            abort(403, 'Colocation annulée.');
        }

        $isActiveMember = $colocation->memberships()
            ->where('user_id', $user->id)
            ->whereNull('left_at')
            ->exists();

        if (! $isActiveMember) {
            abort(403, 'Membres actifs uniquement.');
        }

        return $colocation;
    }

    private function ensureCategoryBelongsToColocation(Category $category, Colocation $colocation): void
    {
        if ((int) $category->colocation_id !== (int) $colocation->id) {
            abort(403);
        }
    }
}
