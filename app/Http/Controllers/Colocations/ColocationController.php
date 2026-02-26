<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    function index()
    {
        return view('colocations.index');
    }
    function create()
    {
        return view('colocations.create');
    }
    function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'min:3', 'string', 'max:20'],
            'description' => ['min:5', 'string', 'max:300'],
        ]);
        Colocation::create([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'created_by' => User::id()
        ]);
    }
}
// Route::view('/colocations', 'colocations.index');
// Route::view('/colocations/create', 'colocations.create');
// Route::view('/colocations/{id}', 'colocations.show');
