@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    @if (Session::get('success'))
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <div id="charge-message" class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        </div>
    </div>
    @endif
    @foreach($products->chunk(3) as $productChunk)
        <div class="row">
            @foreach($productChunk as $product)
                <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="{{ $product->imagePath }}" alt="{{ $product->title }}" class="img-responsive">
                    <div class="caption">
                        <h4>{{ $product->title }}</h4>
                        <p class="description">
                            {{ mb_strimwidth($product->description, 0, 100, '...') }}
                        </p>
                        <div class="clearfix">
                            <div class="pull-left price">{{ $product->price }}円</div>
                            <a href="{{ route('product.addToCart', ['id' => $product->id]) }}" class="btn btn-success pull-right" role="button">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endforeach
@endsection
