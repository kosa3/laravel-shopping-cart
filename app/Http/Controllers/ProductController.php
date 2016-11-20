<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;

use App\Http\Requests;

class ProductController extends Controller
{
    public function getIndex() {
        $products = Product::all(); //Productテーブルのデータを取得してすべてをviewに渡す
        return view('shop.index', ['products' => $products]);
    }

    public function getAddToCart(Request $request, $id) {
        $product = Product::find($id); //商品IDで商品を見つける
        $oldCart = Session::has('cart') ? Session::get('cart') : null; //Sessionにcartがあればそのデータを、なかったらnullを
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return redirect()->route('product.index');
    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart', ['products' => null]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout() {
        if(!Auth::user()) {
            return redirect()->route('user.signin');
        }

        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout', ['total' => $total]);
    }

    public function postCheckout(Request $request) {
        if(!Auth::user()) {
            return redirect()->route('user.signin');
        }
        if (!Session::has('cart')) {
            return redirect()->route('shop.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        Stripe::setApiKey('sk_test_40PIm5XqbacAwU1YZL7DLeIS');
        try {
            $charge = Charge::create(array(
                "amount" => $cart->totalPrice,
                "currency" => "jpy",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Test Charge"
            ));

            $order = new Order();
            $order->cart = serialize($cart);
            $order->address = $request->input('address');
            $order->name = $request->input('name');
            $order->payment_id = $charge->id;

            Auth::user()->orders()->save($order);
        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', $e->getMessage());
        }

        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Successfully purchased product!');
    }
}
