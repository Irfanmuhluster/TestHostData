<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\product;
use App\Models\transaction;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {         
            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);

            $cart = Cart::create([
                'user_id' => auth()->id(),
                'checked_out' => 0
            ]);
            $cart->cartItems()->create([
                'product_id' => $request->input('product_id'),
                'quantity' => 1
            ]);
            
            return redirect()->back()->with('success', 'Berhasil tambah ke keranjang!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
    
    public function Cart()
    {
        $cart = Cart::where('user_id', auth()->id())->where("checked_out",0)->first();
        if ($cart) {
            $cartItems = $cart->cartItems;
            return view('member.cart', compact('cartItems'));
        } else {
            return view('member.cart')->with('message', 'Keranjang Anda kosong.');
        }
    }

    public function checkout(Request $request)
    {

        try {
            $cartItems = json_decode($request->input('cartItems'));
            // dd($cartItems);

            if (empty($cartItems)) {
                return redirect()->back()->with('error', 'Keranjang Anda kosong.');
            }
            
            foreach ($cartItems as $item) {
                // dd($item->product_id);
                $product = product::find($item->product_id);
                // dd($product);
                if ($product) {
                    if ($product->stock < $item->quantity) {
                        return redirect()->back()->with('error', "Stok kurang untuk produk {$product->name}");
                }

                $product->stock -= $item->quantity;
                $product->save();

                $user = User::find(auth()->id());
                $totalPrice = $product->price * $item->quantity;
                    if ($user->balance < $totalPrice) {
                        return redirect()->back()->with('error', "Saldo kamu kurang untuk melakukan checkout.");
                    }
                    $user->balance -= $totalPrice;
                    $user->save();
                }
            }

            $cart = Cart::where('user_id', auth()->id())->find($item->cart_id);
            if ($cart) {
                $cart->checked_out = 1;
                $cart->save();
            }

            foreach ($cartItems as $item) {
                transaction::insert([
                    'user_id' => auth()->id(),
                    'product_id' => $item->product_id,
                    'cart_id' => $cart->id,
                    'quantity' => $item->quantity,
                    'total_price' => $product->price * $item->quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // dd($cart);
            return redirect()->route('member.transaction', $cart->id)->with('success', 'Berhasil tambah keranjang!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd($e->validator);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function transaction($id)
    {
        $transactions = transaction::where('user_id', auth()->id())->with('user')->where("cart_id", $id)->first();
        // dd($transactions);
        return view('member.TransactionSuccess', compact('transactions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
