<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\book;
use App\Models\user_review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class homeController extends Controller
{
    public function home(Request $request){
        $books = book::orderBy('created_at', 'desc')->where('status', 1);

        if(!empty($request->search)){
            $books = $books->where('title','like','%'.$request->search.'%')
                           ->orWhere('author','like','%'.$request->search.'%');
        }
        $books = $books->paginate(10);
        return view('front.home.home' , compact('books'));
    }


    public function detail($id){
        $books = book::with(['reviews.user','reviews' => function($query){
            $query->where('status', 1);
        }])->findOrFail($id);
        if($books->status == 0){
            abort(404);
        }
        $relatedBooks = book::where('status', 1)->where('id','!=',$id)->take(3)->inRandomOrder()->get();
        if($books == null){
            abort(404);
        }
        return view('front.home.detail', compact('books','relatedBooks'));
    }


    public function addBookReview(Request $request){

        $validator = Validator::make($request->all(),[
            'review' => 'required|min:20',
            'rating' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }else{
            $review = new user_review();
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->user_id = Auth::user()->id;
            $review->book_id = $request->book_id;
            $review->save();
            session()->flash('success','review submitted successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }
    }





}
