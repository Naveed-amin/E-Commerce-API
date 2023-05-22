<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(10));
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
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'user_id' => Auth::user()->id,
            'name'=>$request->name,
            'details'=>$request->details,
            'price'=>$request->price,
            'stock' => $request->stock,
            'discount'=>$request->discount,
        ]);
        
        return response([
            'data'=> new ProductResource($product),
        ],Response::HTTP_OK);

        // return new JsonResponse(
        //     data: new ProductResource($product),
        //     status: Response::HTTP_OK,
        // );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
       $updatedData = $product->update([
            'name'=>$request->name,
            'details'=>$request->details,
            'price'=>$request->price,
            'stock' => $request->stock,
            'discount'=>$request->discount,
        ]);
        return response([
            'data' => new ProductResource($product),
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(['date'=>'Product Deleted Sucessfully'],200);
    }
}
