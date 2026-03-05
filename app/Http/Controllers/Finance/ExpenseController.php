<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ExpenseController extends Controller
{
    public function index(Request $request, $id)
    {
        $request->validate([
            'month' => ['nullable', 'regex:/^\d{4}-\d{2}$/'],
            'category' => ['nullable', 'integer'],
        ]);

        $colocation = Colocation::findOrFail($id);
        $userId = $request->user()->id;

        if (!$colocation->memberships()->where('user_id', $userId)->exists()) {
            abort(403);
        }

        $month = $request->string('month')->toString();
        $categoryId = $request->string('category')->toString();

        $expensesQuery = $colocation->expenses()
            ->with(['payer', 'category']);

        if ($month !== '') {
            $expensesQuery->whereYear('spent_at', substr($month, 0, 4))
                ->whereMonth('spent_at', substr($month, 5, 2));
        }

        if ($categoryId !== '') {
            $expensesQuery->where('category_id', (int) $categoryId);
        }

        $expenses = $expensesQuery
            ->latest('spent_at')
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'payer_id' => $e->payer_id,
                'title' => $e->title,
                'amount' => number_format($e->amount, 2) . ' MAD',
                'payer' => $e->payer->name,
                'category' => $e->category->name ?? 'Sans catégorie',
                'color' => $e->category->color ?? '#6B7280',
                'date' => $e->spent_at->format('d/m/Y'),
            ]);

        $months = $colocation->expenses()
            ->orderByDesc('spent_at')
            ->get(['spent_at'])
            ->map(fn($expense) => $expense->spent_at->format('Y-m'))
            ->unique()
            ->values()
            ->mapWithKeys(fn($m) => [$m => \Carbon\Carbon::createFromFormat('Y-m', $m)->translatedFormat('F Y')]);

        $categories = $colocation->categories()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
            ]);

        return view('expenses.index', compact('colocation', 'expenses', 'months', 'categories'));
    }

    public function create(Request $request, $id)
    {
        $colocation = Colocation::findOrFail($id);
        $userId = $request->user()->id;

        $isActiveMember = $colocation->memberships()
            ->where('user_id', $userId)
            ->whereNull('left_at')
            ->exists();

        if (! $isActiveMember) {
            abort(403);
        }

        $categories = $colocation->categories;
        return view('expenses.create', compact('colocation', 'categories'));
    }
    
    public function store(Request $request, $id)
    {
        $colocation = Colocation::findOrFail($id);
        $userId = $request->user()->id;

        $membership = $colocation->memberships()
            ->where('user_id', $userId)
            ->whereNull('left_at')
            ->first();

        if (!$membership) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|integer',
            'spent_at' => 'required|date',
        ]);

        $categoryBelongsToColocation = $colocation->categories()
            ->where('id', $validated['category_id'])
            ->exists();

        if (! $categoryBelongsToColocation) {
            return back()->withErrors(['category_id' => 'Catégorie invalide pour cette colocation.'])->withInput();
        }

        $expenseData = [
            'colocation_id' => $colocation->id,
            'payer_id' => $userId,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'spent_at' => $validated['spent_at'],
        ];

        if (Schema::hasColumn('expenses', 'member_count')) {
            $expenseData['member_count'] = max(1, $colocation->memberships()->whereNull('left_at')->count());
        }

        Expense::create($expenseData);

        return redirect()->route('colocations.show', $colocation)->with('success', 'Dépense ajoutée.');
    }

    public function edit(Expense $expense)
    {
        $colocation = $expense->colocation;
        $categories = $colocation->categories;

        $userId = request()->user()->id;
        $membership = $colocation->memberships()->where('user_id', $userId)->whereNull('left_at')->first();

        if (!$membership || $expense->payer_id !== $userId) {
            abort(403);
        }

        return view('expenses.edit', compact('expense', 'colocation', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $colocation = $expense->colocation;
        $userId = $request->user()->id;

        $membership = $colocation->memberships()->where('user_id', $userId)->whereNull('left_at')->first();

        if (!$membership || $expense->payer_id !== $userId) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|integer',
            'spent_at' => 'required|date',
        ]);

        $categoryBelongsToColocation = $colocation->categories()
            ->where('id', $validated['category_id'])
            ->exists();

        if (! $categoryBelongsToColocation) {
            return back()->withErrors(['category_id' => 'Catégorie invalide pour cette colocation.'])->withInput();
        }

        $expense->update($validated);

        return redirect()->route('colocations.show', $colocation)->with('success', 'Dépense modifiée.');
    }

    public function destroy(Expense $expense)
    {
        $colocation = $expense->colocation;
        $userId = request()->user()->id;

        $membership = $colocation->memberships()->where('user_id', $userId)->whereNull('left_at')->first();

        if (!$membership || $expense->payer_id !== $userId) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('colocations.show', $colocation)->with('success', 'Dépense supprimée.');
    }

}
