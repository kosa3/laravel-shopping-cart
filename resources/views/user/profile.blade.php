@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>User Profile</h1>
            <h2>My Orders</h2>
            @foreach($orders as $order)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($order->cart->items as $item)
                                <span class="badge">{{ $item['price'] }} 円</span>
                                {{ $item['item']['title'] }} | {{ $item['qty'] }} Units
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <strong>
                            Total Prices: {{ $order->cart->totalPrice }} 円
                        </strong>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
