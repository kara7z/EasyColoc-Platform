<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;


class ColocationController extends Controller
{
    function index()
    {
        return view('colocations.index');
    }
}
// Route::view('/colocations', 'colocations.index');
// Route::view('/colocations/create', 'colocations.create');
// Route::view('/colocations/{id}', 'colocations.show');
