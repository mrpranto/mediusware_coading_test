<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use App\Services\ProductServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(ProductServices $productServices)
    {
        $this->service = $productServices;
    }

    public function index(Request $request)
    {
        return view('products.index', $this->service->getProducts($request));
    }


    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    public function store(Request $request): JsonResponse
    {
        $this->service->storeProducts($request);

        return response()->json([
            'success' => true,
            'message' => 'Data Store Successful'
        ]);
    }



    public function show($product)
    {

    }


    public function edit(Product $product)
    {
        $variants = Variant::all();

        return view('products.edit', compact('variants', 'product'));
    }

    public function update(Request $request, Product $product)
    {
        //
    }


    public function destroy(Product $product)
    {
        //
    }
}
