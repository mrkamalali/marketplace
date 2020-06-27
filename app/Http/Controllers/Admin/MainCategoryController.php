<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    public function index()
    {

        $maincats = MainCategory::where('translation_lang', getDefaultLang())->selection()->get();
        return view('admin.maincats.index', compact('maincats'));

    }


    public function create()
    {
        return view('admin.maincats.create');
    }












}
