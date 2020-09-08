<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Model\Book;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::latest()->paginate(10));
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
            'book_photo' => ['required'],
            'book_name' => ['required', 'string'],
            'book_description' => ['required', 'string'],
            'book_author' => ['required', 'string'],
            'book_publisher' => ['required', 'string'],
            'book_pages' => ['required', 'integer'],
            'book_year' => ['required', 'integer'],
            'catalogue_no' => ['required', 'string'],
            'accession_no' => ['required', 'string'],
            'book_status' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'book_type_id' => ['required', 'integer'],
        ]);

        if($request->book_photo){

            $photo_name = time().'.' . explode('/', explode(':', substr($request->book_photo, 0, strpos($request->book_photo, ';')))[1])[1];
            \Image::make($request->book_photo)->save(public_path('img/books/').$photo_name);
            $request->merge(['book_photo' => $photo_name]);

        }

        $book = new Book();
        // $book_photo = '';

        try{

            // if ($request->book_photo!='') {
            //     $book_photo = time().'.jpg';
            //     file_put_contents('storage/books/'.$book_photo,base64_decode($request->book_photo));
            //     $book->book_photo = $book_photo;
            // }#
            $book->book_photo = $photo_name;
            $book->book_name = $request->book_name;
            $book->book_description = $request->book_description;
            $book->book_author = $request->book_author;
            $book->book_publisher = $request->book_publisher;
            $book->book_pages = $request->book_pages;
            $book->book_year = $request->book_year;
            $book->catalogue_no = $request->catalogue_no;
            $book->accession_no = $request->accession_no;
            $book->book_status = $request->book_status;
            $book->category_id = $request->category_id;
            $book->book_type_id = $request->book_type_id;

            $book->save();

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
    public function show(Book $book)
    {
        return new BookResource($book);
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
        $book = Book::findOrFail($id);


        if($request->book_photo){

            $photo_name = time().'.' . explode('/', explode(':', substr($request->book_photo, 0, strpos($request->book_photo, ';')))[1])[1];
            \Image::make($request->book_photo)->save(public_path('img/books/').$photo_name);
            $request->merge(['book_photo' => $photo_name]);

        }

        $this->validate($request, [
            'book_photo' => ['required'],
            'book_name' => ['required', 'string'],
            'book_description' => ['required', 'string'],
            'book_author' => ['required', 'string'],
            'book_publisher' => ['required', 'string'],
            'book_pages' => ['required', 'integer'],
            'book_year' => ['required', 'integer'],
            'catalogue_no' => ['required', 'string'],
            'accession_no' => ['required', 'string'],
            'book_status' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'book_type_id' => ['required', 'integer'],
        ]);

        $book->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return ["Message" => "Book Deleted"];
    }
}
