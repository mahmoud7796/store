<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaincategoriesRequest;
use App\Models\category;
use DB;


class MaincategoriesController extends Controller
{

    public function index(){
        $categories=category::ParentCategory()->orderBy('id','DESC')->paginate(PAGINATION_COUMT);
        return view('admin.categories.index',compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function store(MaincategoriesRequest $request){
        try {

            if(!$request->has('status'))
                $request->request->add(['status'=>0]);
            else
                $request->request->add(['status'=>1]);
            DB::beginTransaction();
            $category = category::create([
                    'slug' => $request -> slug,
                    'is_active' => $request -> status,
                ]);
            $category-> name = $request->name;
            $category -> save();
            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success'=>'تم الإضافة بنجاح']);

        }catch (\Exception $e){
            DB::rollback();
            return redirect()->route('admin.maincategories')->with(['error'=>'حاول قيما بعد']);
        }

    }
    public function edit($id){
        try {
            $mainCategory = category::orderBy('id', 'DESC')->find($id);
            if(!$mainCategory){
                return redirect()->route('admin.maincategories')->with(['error'=>'هذه القسم غير موجود']);
            }
            return view('admin.categories.edit', compact('mainCategory'));
        }catch (\Exception $e){

        }

    }

    public function update(MaincategoriesRequest $request,$id){
        try {

            $category = category::find($id);
            if(!$category)
                return redirect()->route('admin.maincategories')->with(['error'=>'هذا القسم غير موجود']);

            if(!$request->has('status'))
                $request->request->add(['status'=>0]);
            else
                $request->request->add(['status'=>1]);

            $category->update([
                'slug' => $request->slug,
                'is_active' => $request->status,
            ]);
            $category->name= $request->name;
            $category->save();
            return redirect()->route('admin.maincategories')->with(['success'=>'تم التحديث بنجاح']);

        }catch (\Exception $e){

        }

    }
    public function delete($id){
        try{
            $category = category::orderBy('id', 'DESC')->find($id);
            if(!$category)
                return redirect()->route('admin.maincategories')->with(['error'=>'هذا القسم غير موجود']);
            $category->delete();
            return redirect()->route('admin.maincategories')->with(['success'=>'تم الحذف']);

        }catch (\Exception $e){

        }
    }


}
