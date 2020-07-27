<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\MainCategory;
use App\Notifications\VendorRegistration;
use App\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class VendorController extends Controller
{


    public function index()
    {
        $vendors = Vendor::selection()->paginate(50);
        return view('admin.vendors.index', compact('vendors'));
    }


    public function create()
    {
        $categories = MainCategory::where('translation_of', 0)->active()->get();
        return view('admin.vendors.create', compact('categories'));
    }


    public function store(VendorRequest $request)
    {

        try {

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


//            Save Image Td Our Folder And The Path To Database
            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
            }


//            Make A New Vendor
            $vendor = new Vendor();
            $vendor->name = $request['name'];
            $vendor->mobile = $request['mobile'];
            $vendor->email = $request['email'];
            $vendor->password = $request['password'];   // We Hashed Password In Model
            $vendor->address = $request['address'];
            $vendor->category_id = $request['category_id'];
            $vendor->active = $request['active'];
            $vendor->logo = $filePath;
            $vendor->latitude = $request['latitude'];
            $vendor->longitude = $request['longitude'];
            $vendor->save();

//            Send Mail To The New Vendor (TO mailTrap)
            Notification::send($vendor, new VendorRegistration($vendor));

            return redirect()->route('vendors.index')->with(['success' => 'تم ألأضافه بنجاح']);

        } catch (\Exception $ex) {
            return $ex;
            return redirect()->route('vendors.index')->with(['error' => "حدث خطأ ما حاول مره أخرى"]);
        }


    }


    public function edit($id)
    {
        try {
            $vendor = Vendor::selection()->find($id);
            if (!$vendor) {
                return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ ما حاول لأحقا']);
            }
            $categories = MainCategory::where('translation_of', 0)->active()->get();
            return view('admin.vendors.edit', compact('vendor', 'categories'));
        } catch (\Exception $ex) {
            return redirect()->route('vendors.index')->with(['error' => 'هذا العنصر غير موجود ']);
        }
    }


    public function update($id, VendorRequest $request)
    {

        try {
            $vendor = Vendor::find($id);
            if (!$vendor)
                return redirect()->route('vendors.index')->with(['error' => 'هذا الحقل غير موجود ']);

            DB::beginTransaction();
            $data = $request->except(['_token', 'logo', 'password']);

//            Update  logo
            if ($request->logo) {
                $filePath = uploadImage('vendors', $request->logo);
                $data['logo'] = $filePath;
            }

//            Update  Password
            if ($request->password) {
                $data['password'] = $request->password;   // Its Hashed In Database By Default
            }

            Vendor::where('id', $id)->update($data);
            DB::commit();

            return redirect()->route('vendors.index')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ ما حاول لأحقا ']);
        }
    }


    public function destroy($id)
    {
        try {
            $vendor = Vendor::find($id);
            if (!$vendor)
                return redirect()->route('vendors.index')->with(['error' => 'هذا العنصر غير موجود']);

            $imagePath = Str::after($vendor->logo, 'assets/');
            $image = base_path('assets/' . $imagePath);
            unlink($image);

            $vendor->delete();
            return redirect()->route('vendors.index')->with(['success' => 'تم حذف المتجر بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ ما حاول لأحقا']);
        }
    }


    public function status($id)
    {
        try {

            $vendor = Vendor::find($id);
            if (!$vendor)
                return redirect()->route('vendors.index')->with(['error' => 'هذا العنصر غير موجود']);

            $status = $vendor->active == 0 ? 1 : 0;
            $vendor->update(['active' => $status]);
            return redirect()->route('vendors.index')->with(['success' => 'تم تغيير حاله القسم']);

        } catch (\Exception $ex) {
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ ما حاول لأحقا']);
        }
    }


}
