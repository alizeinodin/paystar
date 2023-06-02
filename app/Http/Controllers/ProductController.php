<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(): Collection
    {
        return Product::all();
    }

    public function get(Product $product): JsonResponse
    {
        return response()->json($product, Response::HTTP_OK);
    }
}
