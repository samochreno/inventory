<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index(Request $request)
    {
        return view('parts', [
            'page'   => $request->input('page'),
            'search' => $request->input('search'),
        ]);
    }
}
