<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Review\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->details,
            'price' => $this->price,
            'stock' => $this->stock == 0 ? 'No Stock Available' : $this->stock,
            'discount' => $this->discount. '%',
            'totalPrice' => round((1 - ($this->discount/100))*$this->price,2),
            'reviews' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No Rating Yet',
            // 'all_reviews' => ReviewResource::collection($this->reviews),
            'href' => [
                'reviews' => route('reviews.index',$this->id)
            ]
        ];
    }
}
