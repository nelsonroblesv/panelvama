<?php

namespace App\Http\Controllers;

use App\Models\Familia;

class FamiliaController extends Controller
{
    public function index()
    {
        $familias = Familia::all();

        return view('panel.familias', compact('familias'));
    }
}
