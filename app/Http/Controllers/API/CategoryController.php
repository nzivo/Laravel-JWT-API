<?php

namespace App\Http\Controllers\API;

use App\Role;
use Exception;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Category::latest()->paginate(10);
        return CategoryCollection::collection(Category::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => ['required', 'string', 'max:255', 'unique:categories'],
            'category_description' => ['required', 'string', 'max:255'],
            'category_status' => ['required', 'string', 'max:255'],
        ]);

        $category = new Category;

        try{
            $category->category_name = $request->category_name;
            $category->category_description = $request->category_description;
            $category->category_status = $request->category_status;

            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Added Successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=> false,
                'message' => 'Unsuccessful',
                'error' => ''.$e
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $this->validate($request, [
            'category_name' => 'required|string|max:255|unique:categories,category_name,'.$category->id,
            'category_description' => 'required|string|max:255',
            'category_status' => 'required|string|max:255',
        ]);

        $category->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return ["Message" => "Category Deleted"];
    }

}
