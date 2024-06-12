<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        return view('cars', [
            'page'   => $request->input('page'),
            'search' => $request->input('search'),
            'filter' => $request->input('filter'),
        ]);
    }
}
