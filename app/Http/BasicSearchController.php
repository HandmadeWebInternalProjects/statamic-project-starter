<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Facades\Search;
use Statamic\View\View;

class BasicSearchController extends Controller
{
    public function index(Request $request)
    {
        $searchResults = Search::index('basic-search')->search(request()->get('q'))->get();

        return View::make('basic-search', ['searchResults' => $searchResults]);
    }

    public function results()
    {
    }
}
