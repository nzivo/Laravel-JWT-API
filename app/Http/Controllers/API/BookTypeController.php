<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Model\BookType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookType\BookTypeResource;

class BookTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookTypeResource::collection(BookType::latest()->paginate(10));
        // return BookType::latest()->paginate(10);
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
            'type_name' => ['required', 'string', 'max:255', 'unique:book_types'],
            'type_description' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
        ]);

        $bookType = new BookType;

        try{
            $bookType->type_name = $request->type_name;
            $bookType->type_description = $request->type_description;
            $bookType->category_id = $request->category_id;

            $bookType->save();

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
    public function show(BookType $bookType)
    {
        return new BookTypeResource($bookType);
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
        $bookType = BookType::findOrFail($id);

        $this->validate($request, [
            'type_name' => 'required|string|max:255|unique:book_types,type_name,'.$bookType->id,
            'type_description' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $bookType->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookType = BookType::findOrFail($id);

        $bookType->delete();

        return ["Message" => "Book Type Deleted"];
    }
}
