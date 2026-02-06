<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function index()
    {
        return view('public.catalog');
    }
}
