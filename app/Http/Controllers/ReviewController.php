<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Product;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        
        return ReviewResource::collection($product->reviews()->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request, Product $product)
    {
       $review =  $product->reviews()->create([
            'product_id' => $product->id,
            'customer' => $request->customer,
            'review' => $request->review,
            'star' => $request->star
        ]);
    return response([
        'data' => new ReviewResource($review)
    ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Product $product, Review $review)
    {
        
        $review->update($request->all());
        return response([
            'data' => new ReviewResource($review)
        ],201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Review $review)
    {
        $review->delete();
        return response([
            'data' =>'Review Deleted successfully'
        ],200);

    }
}
