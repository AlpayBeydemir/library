<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Exception;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public function index()
    {
        $data['categories'] = Categories::all();
        return view("admin.category.category", $data);
    } // End Function

    public function AddCategory()
    {
        return view("admin.category.category_add");
    } // End Function

    public function StoreCategory(Request $request)
    {

//        dd($request);

        try {
            if (!isset($request->name) || empty($request->name)){
                throw new \Exception("Please Enter Category Name");
            } else{

                $category = new Categories();

                $category->name       = $request->name;
                $category->is_active  = 1;
                $category->created_at = Carbon::now();

                $category->save();

                $notification = array(
                    'message'    => 'Category Inserted Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->route('category')->with($notification);
            }
        }
        catch (\Exception $e){

            $notification = array(
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            );

            return back()->with($notification);
        }

    } // End Function

    public function EditCategory($id)
    {
        $data['category'] = Categories::findOrFail($id);
        return view("admin.category.category_edit", $data);
    } // End Function

    public function UpdateCategory(Request $request, $id)
    {

        try {
            if (!isset($request->name) || empty($request->name)){
                throw new \Exception("Please Enter Category Name");
            }
            else {
                $category = Categories::find($id);

                $category->name       = $request->name;
                $category->is_active  = 1;
                $category->updated_at = Carbon::now();

                $category->update();

                $notification = array(
                    'message' => 'Category Name Updated Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->route('category')->with($notification);
            }
        }
        catch (\Exception $e){
            $notification = array(
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            );

            return back()->with($notification);
        }

    } // End Function

    public function DeleteCategory($id)
    {

        try {
            $category = Categories::find($id);
            if (!$category){
                throw new \Exception("The Category Could Not Found");
            }
            else {
                $deleted_category = Categories::find($id)->delete($category);
                if (!$deleted_category){
                    throw new \Exception("The Category Could Not Delete. Please Try Again Later.");
                }
                else {
                    $notification = array(
                        'message'    => 'Category Deleted Successfully',
                        'alert-type' => 'success'
                    );

                    return redirect()->back()->with($notification);
                }
            }
        }
        catch (\Exception $e){
            $notification = array(
                'message'    => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    } // End Function
}
