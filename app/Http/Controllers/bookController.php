<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class bookController extends Controller
{


  public function index(Request $request){

    $books = book::orderBy('created_at','desc');
    if(!empty($request->keyword)){
      $books->where('title','LIKE','%'.$request->keyword.'%')->orWhere('author','LIKE','%'.$request->keyword.'%');
    }  
    $books = $books->paginate(5);
    return view('front.books.list', compact('books'));
  }



  // not working blow index code############################

  // public function index(Request $request){
  //   $books = book::orderBy('created_at','desc');

  //   if($request->ajax()){
  //     $books->where('title','LIKE','%'.$request->keyword.'%');

  //   }
    
    
  //   $books = $books->paginate(5);

  // }

// ***********************************************



  public function create(){
    return view('front.books.create-book');
  }



  public function store(Request $request){
    $rules = [
        'title' => 'required|min:5',
        'author' => 'required|min:6'            
    ];
    if(!empty($request->image)){
        $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif';
    }
    $validator = validator::make($request->all(),$rules);
    if($validator->fails()){
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }else{
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

        if(!empty($request->image)){
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('uploads/books'),$imageName);
            $book->image = $imageName;
            $book->save();

            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/'.$imageName));
            $img->resize(990);
            $img->save(public_path('uploads/books/thumb/'.$imageName));
        }
        session()->flash('success','your new book created');
        return response()->json([
            'status' => true,
            'errors' => []
        ]);
    }  
  }


  public function edit($id){
    $book = book::findOrFail($id);
    return view('front.books.edit-book' , compact('book'));
  }


  public function update($id ,Request $request ){
    $rules = [
      'title' => 'required|min:5',
      'author' => 'required|min:6'
    ];
    if(!empty($request->image)){
      $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif';
    }
    $validator = validator::make($request->all(),$rules);

    if($validator->fails()){
      return response()->json([
        'status' => false,
        'errors' => $validator->errors()
      ]);
    }else{
      $book = book::findOrFail($id);
      $book->title = $request->title;
      $book->author = $request->author;
      $book->description = $request->description;
      $book->status = $request->status;
      $book->save();

      if(!empty($request->image)){

        File::delete(public_path('uploads/books/'.$book->image));
        File::delete(public_path('uploads/books/thumb/'.$book->image));

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = $id.time().'.'.$ext;
        $image->move(public_path('uploads/books'),$imageName);
        $book->image = $imageName;
        $book->save();
  
        $manager = new ImageManager(Driver::class);
        $img = $manager->read(public_path('uploads/books/'.$imageName));
        $img->resize(990);
        $img->save(public_path('uploads/books/thumb/'.$imageName));
      }
      session()->flash('success','your  book updated successfully');
      return response()->json([
        'status' => true,
        'errors' => []
      ]);
    }
  }

 

  public function destroy(Request $request){
    $id = $request->id;

    $book = book::find($id);

    if($book == null){
      session()->flash('success','your book deleted successfully');
      return response()->json([
        'status' => false,
        'messase' => "book not found"
      ]);

    }else{
      File::delete(public_path('uploads/books/'.$book->image));
      File::delete(public_path('uploads/books/thumb/'.$book->image));
  
      $book->delete();
      session()->flash('success','your book deleted successfully');
      return response()->json([
        'status' => true,
        'messase' => "book deleted"
      ]);

    }

    // return view('front.books.create-book');
  }


}
