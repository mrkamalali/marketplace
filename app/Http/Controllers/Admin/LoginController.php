<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\MessageBag;

class LoginController extends Controller
{

    public function getLogin()
    {
        return view('admin.Auth.login');
    }

    public function login(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            // notify()->success('تم الدخول بنجاح  ');
            return redirect()->route('admin.dashboard');
        }
        // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
//        $error = new MessageBag(['password' => __('site.wrongLogin')]);
        return redirect()->back()->with('error', __('site.wrongLogin'));


    }


    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect('admin/login');
    }



}
