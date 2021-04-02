@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" value="{{ request('title') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        <option value="" selected>- Select Variant -</option>
                        @foreach($variants as $key => $variant)
                            <optgroup label="{{ $variant->title }}">
                                @foreach($variant->productVariants as $key => $productVariant)
                                    <option {{ request('variant') == $productVariant->id ? 'selected' : '' }} value="{{ $productVariant->id }}">{{ $productVariant->variant }}</option>
                                @endforeach

                            </optgroup>

                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" value="{{ request('price_from') }}" aria-label="First name" placeholder="From"
                               class="form-control">
                        <input type="text" name="price_to" value="{{ request('price_to') }}" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" value="{{ request('date') }}" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($products as $key => $product)

                        <tr>
                            <td>{{ ($products->firstItem() + $key) }}</td>
                            <td>{{ $product->title }} <br> Created at : {{ $product->created_at->format('d-M-Y') }}
                                25-Aug-2020
                            </td>
                            <td>{{ $product->description }}</td>
                            <td>

                                @foreach($product->productVariantPrices as $product_price)

                                    <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                        <dt class="col-sm-3 pb-0">
                                            {{ $product_price->title }}
                                        </dt>


                                        <dd class="col-sm-9">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4 pb-0">Price
                                                    : {{ number_format($product_price->price,2) }}</dt>
                                                <dd class="col-sm-8 pb-0">InStock
                                                    : {{ number_format($product_price->stock,2) }}</dd>
                                            </dl>
                                        </dd>


                                    </dl>

                                @endforeach

                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <th colspan="5" class="text-center">No Data found !</th>
                        </tr>

                    @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ request('page') }} to {{ $products->perpage() }} out of {{ $products->total() }}</p>
                </div>
                <div class="col-md-2">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
