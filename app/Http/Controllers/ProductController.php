<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
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
        return view('products.create', [
            'variants' => Variant::all()
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->service
            ->validateProduct($request)
            ->storeProducts($request);

        return response()->json([
            'success' => true,
            'message' => 'Data Store Successful'
        ]);
    }


    public function show(Product $product): Product
    {
        return $product->load('productImages', 'productVariants', 'productVariantPrices');
    }


    public function edit(Product $product)
    {
        return view('products.edit', [

            'variants' => Variant::all(),
            'product' => $product->load('productImages', 'productVariants', 'variants', 'productVariantPrices'),
            'productVariants' => ProductVariant::query()
                ->where('product_id', $product->id)
                ->get(['variant', 'variant_id'])->groupBy('variant_id')
                ->map(function ($variant) {
                    return $variant->pluck('variant')->toArray();
                })
        ]);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
//        dd($request->all());

        $this->service
            ->validateProduct($request, $product->id)
            ->updateProduct($request, $product);

        return response()->json([
            'success' => true,
            'message' => 'Data Update Successful'
        ]);
    }


    public function destroy(Product $product)
    {
        //
    }
}
