<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class ProductList extends Component
{
    public function addToCart($productId)
    {
        $user = Auth::user();
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);
        $product = Product::find($productId);
        if ($product->stock_quantity > 0) {
            $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => 1
                ]);
            }
            session()->flash('message', 'Product added to cart!');
        } else {
            session()->flash('error', 'Product out of stock!');
        }
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.product-list', compact('products'));
    }
}
