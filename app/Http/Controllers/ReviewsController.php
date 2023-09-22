<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a listing of the resource.
    public function index()
    {
        //
    }

    // Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'review' => 'required|min:1'
        ]);

        $review = new Review();
        $review->product_id = $id;
        $review->user_id = auth()->user()->id;
        $review->text = $request->input('review');
        $review->save();

        return redirect("/product/$id")->with('success', 'Отзыв добавлен');
    }

    // Display the specified resource.
    public function show($id)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        //
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $review = Review::find($id);
        if(auth()->user()->id != $review->user_id)
            return redirect('/')->with('error', 'Это не ваш отзыв');
        
        $review->delete();
        return redirect("/product/$review->product_id")->with('success', 'Отзыв удален');
    }
}