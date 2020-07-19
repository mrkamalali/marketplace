<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LangRequest;
use App\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::selection()->paginate(PAGINATE_COUNT);
        return view('admin.languages.index', compact('languages'));
    }


    public function create()
    {
        return view('admin.languages.create');
    }


    public function store(LangRequest $request)
    {

        try {
            Language::create($request->except(['_token']));
            return redirect()->route('site.languages.index')
                ->with(['success' => 'ثم ألاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدثت مشكله ما حاول مره اخرى ']);
        }

    }


    public function edit($id)
    {
        $language = Language::select()->find($id);
        if (!$language) {
            return redirect()->route('site.languages.index')->with(['error' => 'هذه اللغه غير موجوده ']);
        }
        return view('admin.languages.edit', compact('language'));


    }


    public function update(LangRequest $request, $id)
    {
        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('site.languages.edit', $id)
                    ->with(['error' => 'هذه اللغة غير موجوده']);
            }

//            To Check IF Our Request Has Not A Value For Active.. We Should Add ..
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            $language->update($request->except('_token'));
            return redirect()->route('site.languages.index')
                ->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('site.languages.index')
                ->with(['error' => 'حدثت مشكله ما حاول مره اخرى ']);
        }

    }


    public function destroy($id)
    {
        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('site.languages.edit', $id)
                    ->with(['error' => 'هذه اللغة غير موجوده']);
            }


            $language->delete();
            return redirect()->route('site.languages.index')
                ->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('site.languages.index')
                ->with(['error' => 'حدثت مشكله ما حاول مره اخرى ']);
        }
    }


}
