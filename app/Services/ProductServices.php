<?php


namespace App\Services;


use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductServices
{
    public $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProducts($request): array
    {
        return [

            'variants' => Variant::query()->with('productVariants')->get(['title', 'id']),

            'products' => $this->model::query()
                ->with('variants', 'productVariantPrices')
                ->when($request->title , function (Builder $builder) use($request){
                    $builder->where('title', 'like', '%'.$request->title.'%');
                })
                ->when($request->variant , function (Builder $builder) use($request){
                    $builder->whereHas('productVariants', function (Builder $builder) use($request){
                        $builder->where('id', $request->variant);
                    });
                })
                ->when($request->price_from and $request->price_to, function (Builder $builder) use($request){
                    $builder->whereHas('productVariantPrices', function (Builder $builder) use($request){
                        $builder->whereBetween('price', [$request->price_from, $request->price_to]);
                    });
                })
                ->when($request->date, function (Builder $builder) use($request){
                    $builder->whereDate('created_at', $request->date);
                })
                ->paginate(2)
        ];
    }

    public function storeProducts($request)
    {
        DB::transaction(function () use ($request) {

            $this->model = $this->storeProduct($request);

            $this->storeProductVariant($request);

            $this->storeProductVariantPrice($request);

            $this->storeProductImage($request);

        });

    }

    private function storeProduct($request)
    {
        return $this->model::query()->create([

            'title' => $request->title,
            'sku' => $request->sku,
            'description' => $request->description,

        ]);
    }

    private function storeProductVariant($request)
    {
        foreach ($request->product_variant as $key => $variant) {
            foreach ($variant['tags'] as $tag) {

                ProductVariant::query()->create([

                    'variant' => $tag,
                    'variant_id' => $variant['option'],
                    'product_id' => $this->model->id,

                ]);
            }
        }
    }

    private function storeProductVariantPrice($request)
    {
        foreach ($request->product_variant_prices as $key => $product_variant_prices) {
            ProductVariantPrice::query()->create([

                'title' => $product_variant_prices['title'],
                'price' => $product_variant_prices['price'],
                'stock' => $product_variant_prices['stock'],
                'product_id' => $this->model->id,

            ]);
        }

    }

    private function storeProductImage($request)
    {
        if (count($request->product_image)) {

            foreach ($request->product_image as $image) {

                $fileName = date('Ymd') . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('upload', $fileName);

                ProductImage::query()->create([

                    'product_id' => $this->model->id,
                    'file_path' => 'upload/'.$fileName,
                    'thumbnail' => true

                ]);

            }

        }

    }

}
