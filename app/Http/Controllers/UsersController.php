<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function getSignup() {
        return view('user.signup');
    }

    public function postSignup(Request $request) {
        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4'
        ]);
        $user = new User([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        $user->save();

        return redirect()->route('product.index');
    }

    public function getSignin() {
        if(Auth::user()) {
            return redirect()->route('product.index');
        }
        return view('user.signin');
    }

    public function postSignin(Request $request) {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->route('user.profile');
        } else {
            return redirect()->back();
        }
    }

    public function getProfile() {
        if(Auth::user()) {
            $orders = Auth::user()->orders;
            $orders->transform(function ($order, $key) {
                $order->cart = unserialize($order->cart);
                return $order;
            });
            return view('user.profile', ['orders' => $orders]);
        } else {
            return redirect()->route('product.index');
        }
    }

    public function getLogout() {
        Auth::logout();
        return redirect()->route('user.signin');
    }
}
