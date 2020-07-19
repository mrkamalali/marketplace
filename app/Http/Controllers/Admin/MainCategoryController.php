<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCatRequest;
use App\MainCategory;
use Exception;
use Illuminate\Support\Facades\DB;

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

    public function store(MainCatRequest $request)
    {
//        return $request;

        try {
            // Making our categories as a collection to make  filter on it.
            $main_cats = collect($request->category);

            // Making filter on categories to show only ar category.. in  (ar) only
            $mainCat_Filtered = $main_cats->filter(function ($value, $key) {
                return $value['abbr'] == getDefaultLang();
            });

            $default_mainCat = array_values($mainCat_Filtered->all())  [0];

            //  Insert photo to database
            $filePath = "";
            if ($request->has('photo')) {
                $filePath = uploadImage('maincats', $request->photo);
            }

//        Saving category with default language.. after that we add the translations for it..
            DB::beginTransaction(); // To start inserting in database and cancel if not all success
            $default_category_id = MainCategory::insertGetId([
                'translation_lang' => $default_mainCat['abbr'],
                'translation_of' => 0,
                'name' => $default_mainCat['name'],
                'slug' => $default_mainCat['name'],
                'photo' => $filePath,
            ]);

            // Get the categories not in ar ( other Languages  )
            $translations_for_category = $main_cats->filter(function ($value) {
                return $value['abbr'] != getDefaultLang();
            });

            //  Saving the translations of category after we saved the default category with default language  ..
            if (isset($translations_for_category) && $translations_for_category->count()) {
                $categories_array = [];
                foreach ($translations_for_category as $category) {
                    $categories_array[] = [
                        'translation_lang' => $category['abbr'],
                        'translation_of' => $default_category_id,
                        'name' => $category['name'],
                        'slug' => $category['name'],
                        'photo' => $filePath,
                    ];
                }
                MainCategory::insert($categories_array);
            }
            DB::commit(); // If Everything is good

            return redirect()->route('main-cats.index')->with(['success' => 'تم أضافه قسم جديد']);
        } catch (Exception $ex) {
            DB::rollBack();  // if one or all INSERT function in database failed will not saving the data and will return
            return redirect()->back()->with(['error' => 'حدث خطا ما برجاء المحاوله مره اخرى ']);
        }
    }


    public function edit($id)
    {
        $mainCategory = MainCategory::with('categories')->selection()->find($id);
        if (!$mainCategory)
            return redirect()->route('main-cats.index')
                ->with(['error' => 'هذا العنصر غير موجود ']);
        else return view('admin.maincats.edit', compact('mainCategory'));

    }


    public function update($id, MainCatRequest $request)
    {

        try {

            $mainCat = MainCategory::find($id);
            if (!$mainCat)
                return redirect()->route('main-cats.index')->with(['error' => 'هذا العنصر غير موجود ']);

//            To work on index number 0 in this  array and it includes (name,abbr and active )
            $category = array_values($request->category)  [0];
//        Update active column
            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

//            Making Update On Name And Active in Default MainCategory With Default Language.
            MainCategory::where('id', $id)
                ->update([
                    'name' => $category['name'],
                    'active' => $request->active,
                ]);

//            Save Or update image if we have it in request
            if ($request->has('photo')) {
                $filePath = uploadImage('maincats', $request->photo);
                MainCategory::where('id', $id)
                    ->update([
                        'photo' => $filePath,
                    ]);
            }

            return redirect()->route('main-cats.index')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('main-cats.index')->with(['error' => 'حدث خطا ما برجاء المحاوله مره اخرى ']);
        }
    }


}
