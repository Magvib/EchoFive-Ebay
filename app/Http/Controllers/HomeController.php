<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\msg;
use App\Timer;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = Product::all();
        $usr = User::all();
        $msg = msg::all();
        $timer = Timer::all();
        return view('home')
        ->with('product', $product)
        ->with('usr', $usr)
        ->with('msg', $msg)
        ->with('timer', $timer);
    }
    public function deleteUser($id)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $usr = User::find($id);
        $usr->delete();
        return redirect('home')->with("msg", "User Deleted")->with("msgc", "danger");
    }

    public function forceOP($id)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $usr = User::find($id);
        $usr->role_id = 3;
        $usr->save();
        return redirect('home')->with("msg", "The account is now VIP")->with("msgc", "success");
    }

    public function deOP($id)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $usr = User::find($id);
        $usr->role_id = 2;
        $usr->save();
        return redirect('home')->with("msg", "The account is now a user")->with("msgc", "danger");
    }

    public function deleteAccount($id)
    {
        $usr = User::find(Auth::user()->id);
        Auth::logout();

        if ($usr->delete()) {
        return redirect('')->with("msg", "You have deleted your account.")->with("msgc", "danger");
    }
    }

    public function deleteItem($id)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $product =  Product::find($id);
        $product->delete();
        return redirect('home')->with("msg", "Product deleted")->with("msgc", "danger");
    }
    public function uploadItem(Request $request)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $title = $request->input('title');
        $price = $request->input('price');
        $description = $request->input('description');
        Product::create([
            'title' => $title,
            'price' => $price,
            'description' => $description,
            'uid' => 0
        ]);
        return redirect('home')->with("msg", "Product $title uploaded")->with("msgc", "success");
    }

    public function uploadMsg(Request $request)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $text = $request->input('text');
        $color = $request->input('color');
        msg::create([
            'text' => $text,
            'color' => $color,
        ]);
        return redirect('home');
    }
    public function deleteMsg($id)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $msg = msg::find($id);
        $msg->delete();
        return redirect('home')->with("msg", "Message deleted")->with("msgc", "danger");
    }
    public function deleteTime($id)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $timer = Timer::find($id);
        $timer->delete();
        return redirect('home')->with("msg", "Time deleted")->with("msgc", "danger");
    }
    public function buyItem($id, $userId)
    {
        if (Auth::user()->hasRole('user')) {
            return redirect('home')->with("msg", "User not authorized")->with("msgc", "danger");
        }
        $item = Product::find($id);
        $item->uid = $userId;
        $item->save();
        return redirect('home')->with("msg", "You bought the item")->with("msgc", "success");
    }
}
