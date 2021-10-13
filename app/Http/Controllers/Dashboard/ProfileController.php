<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\passwordRequest;
use App\Http\Requests\profileRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editProfile()
    {

        $admin = Admin::find(auth('admin')->user()->id);

        return view('admin.profile.edit', compact('admin'));

    }

    public function updateProfile(ProfileRequest $request)
    {

        try {

            $admin = Admin::find(auth('admin')->user()->id);
            $admin -> email = $request->email;
            $admin -> name = $request->name;
            $admin->save();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }

    }

    public function editPass()
    {
        return view('admin.profile.editPass');
    }

    public function updatePass(passwordRequest $request)
    {
        try{
            $currentPassword = Admin::find(auth('admin')->id())->password;
            if(Hash::check($request-> current_password,$currentPassword)){
                $currentPassword = Admin::find(auth('admin')->id());
                $currentPassword->password = Hash::make($request->password);
                $currentPassword->save();
                auth('admin')-> logout();
                return redirect()->route('admin.login')->with(['success' => 'تم تم تغيير كلمة السر بنجاح']);

            }else{
                return redirect()->back()->with(['error' => 'كلمة السر الحالية غير صحيحة']);

            }

        }catch (\Exception $e){
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }

    }
}
