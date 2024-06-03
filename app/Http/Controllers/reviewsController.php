<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\user_review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

   public function editReview($id){
    $review = user_review::findOrFail($id);
    return view('front.reviews.edit-review', compact('review'));

   }


   public function updateReview($id , Request $request){

    $validator = Validator::make($request->all(),[
        'review' => 'required',
        'status' => 'required'
    ]);
    if($validator->passes()){
        $review = user_review::findOrFail($id);
        $review->review = $request->review;
        $review->status = $request->status;
        $review->save();

        session()->flash('success','your review has updated successfully');
        return response()->json([
            'status' => true,
            'errors' => []
        ]);
    }else{
        session()->flash('error','try again');
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
}


public function deleteReview($id){
    $review = user_review::findOrFail($id);
    $review->delete();    
    
    session()->flash('success','your review has deleted successfully');
    return response()->json([
        'status' => true,
        'message' => 'review deleted successfully'
    ]);
}





}
