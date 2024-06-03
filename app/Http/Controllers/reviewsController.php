<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\user_review;
use Illuminate\Http\Request;

class reviewsController extends Controller
{
   public function allReviews(Request $request){

    $reviews = user_review::with('book','user')->orderBy('created_at','desc');
    if(!empty($request->keyword)){
        $reviews = $reviews->where('review','like','%'.$request->keyword.'%');
                            //   ->orWhere('user.title','like','%'.$request->keyword.'%');
    }    
    $reviews = $reviews->paginate(3);
    return view('front.reviews.reviews-page', compact('reviews'));
   }

   public function editreview(){

    

   }





}
