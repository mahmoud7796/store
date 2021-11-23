<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\category;
use DB;


class SubCategoriesController extends Controller
{
    public function index(){
          $subCategories=category::with(['mainCategories'=>function ($q){
            $q->select('id');
        }])->SubParentCategory()->orderBy('id','DESC')->paginate(PAGINATION_COUMT);
        return view('admin.subcategories.index',compact('subCategories'));
    }

    public function create(){
          $mainCategories=category::ParentCategory()->get();
        return view('admin.subcategories.create',compact('mainCategories'));
    }

    public function store(SubCategoryRequest $request){
        try {

            if(!$request->has('status'))
                $request->request->add(['status'=>0]);
            else
                $request->request->add(['status'=>1]);

            DB::beginTransaction();
            $category = category::create([
                'parent_id'=> $request->main_category_id,
                'slug' => $request -> slug,
                'is_active' => $request -> status,
            ]);
            $category-> name = $request->name;
            $category -> save();
            DB::commit();
            return redirect()->route('admin.subcategories')->with(['success'=>'تم الإضافة بنجاح']);

        }catch (\Exception $e){
            DB::rollback();
            return redirect()->route('admin.subcategories')->with(['error'=>'حاول قيما بعد']);
        }

    }
    public function edit($id){
        try {
            $subCategory = category::orderBy('id', 'DESC')->find($id);
            if(!$subCategory){
                return redirect()->route('admin.subcategories')->with(['error'=>'هذه القسم غير موجود']);
            }
            $mainCategories=category::ParentCategory()->get();
            return view('admin.subcategories.edit', compact('subCategory','mainCategories'));
        }catch (\Exception $e){

        }

    }

    public function update(SubCategoryRequest $request,$id){
        try {

            $category = category::find($id);
            if(!$category)
                return redirect()->route('admin.subcategories')->with(['error'=>'هذا القسم غير موجود']);

            if(!$request->has('status'))
                $request->request->add(['status'=>0]);
            else
                $request->request->add(['status'=>1]);

            $category->update([
                'parent_id'=> $request->main_category_id,
                'slug' => $request->slug,
                'is_active' => $request->status,
            ]);
            $category->name= $request->name;
            $category->save();
            return redirect()->route('admin.subcategories')->with(['success'=>'تم التحديث بنجاح']);

        }catch (\Exception $e){

        }

    }
    public function delete($id){
        try{
            $category = category::orderBy('id', 'DESC')->find($id);
            if(!$category)
                return redirect()->route('admin.subcategories')->with(['error'=>'هذا القسم غير موجود']);
            $category->delete();
            return redirect()->route('admin.subcategories')->with(['success'=>'تم الحذف']);

        }catch (\Exception $e){

        }
    }


}
