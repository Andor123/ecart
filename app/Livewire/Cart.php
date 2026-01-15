<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendLowStockNotification;

class Cart extends Component
{
    public $cartItems = [];

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
    {
        $user = Auth::user();
        if ($user->cart) {
            $this->cartItems = $user->cart->cartItems->load('product')->toArray();
        }
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeItem($cartItemId);
            return;
        }
        $cartItem = CartItem::find($cartItemId);
        $product = $cartItem->product;
        if ($quantity > $product->stock_quantity) {
            session()->flash('error', 'Not enough stock!');
            return;
        }
        $cartItem->update(['quantity' => $quantity]);
        $this->loadCartItems();
        session()->flash('message', 'Quantity updated!');
    }

    public function removeItem($cartItemId)
    {
        CartItem::find($cartItemId)->delete();
        $this->loadCartItems();
        session()->flash('message', 'Item removed!');
    }

    public function checkout()
    {
        $user = Auth::user();
        $cart = $user->cart;
        if (!$cart || $cart->cartItems->isEmpty()) {
            session()->flash('error', 'Cart is empty!');
            return;
        }
        DB::transaction(function () use ($cart, $user) {
            $total = 0;
            $order = Order::create([
                'user_id' => $user->id,
                'total' => 0
            ]);
            foreach ($cart->cartItems as $cartItem) {
                $product = $cartItem->product;
                if ($cartItem->quantity > $product->stock_quantity) {
                    throw new \Exception('Not enough stock for ' . $product->name);
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price
                ]);
                $total += $cartItem->quantity * $product->price;
                $product->decrement('stock_quantity', $cartItem->quantity);
                if ($product->stock_quantity < 5) {
                    SendLowStockNotification::dispatch($product);
                }
            }
            $order->update(['total' => $total]);
            $cart->cartItems()->delete();
        });
        $this->loadCartItems();
        session()->flash('message', 'Order placed successfully!');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
