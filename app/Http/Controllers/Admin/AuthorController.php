<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Exception;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $data['authors'] = Author::all();
        return view("admin.author.author", $data);
    } // End Function

    public function AddAuthor()
    {
        return view("admin.author.author_add");
    } // End Function

    public function StoreAuthor(Request $request)
    {

//        dd($request);

        try {
            if (!isset($request->name) || empty($request->name) || trim($request->name == "")){
                throw new \Exception("Please Enter Author Name");
            } else{

                $author = new Author();

                $author->name       = $request->name;

                $author->save();

                $notification = array(
                    'message'    => 'Author Inserted Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->route('author')->with($notification);
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

    public function EditAuthor($id)
    {
        $data['author'] = Author::findOrFail($id);
        return view("admin.author.author_edit", $data);
    } // End Function

    public function UpdateAuthor(Request $request, $id)
    {

        try {
            if (!isset($request->name) || empty($request->name) || trim($request->name == "")){
                throw new \Exception("Please Enter Author Name");
            }
            else {
                $author = Author::find($id);

                $author->name       = $request->name;

                $author->update();

                $notification = array(
                    'message' => 'Author Name Updated Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->route('author')->with($notification);
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

    public function DeleteAuthor($id)
    {

        try {
            $author = Author::find($id);
            if (!$author){
                throw new \Exception("The Author Could Not Found");
            }
            else {
                $deleted_author = Author::find($id)->delete($author);
                if (!$deleted_author){
                    throw new \Exception("The Author Could Not Delete. Please Try Again Later.");
                }
                else {
                    $notification = array(
                        'message'    => 'Author Deleted Successfully',
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
