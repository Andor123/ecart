<div>
    <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif
    @if(empty($cartItems))
        <p>Your cart is empty.</p>
    @else
        <div class="space-y-4">
            @foreach($cartItems as $item)
                <div class="flex items-center justify-between border rounded-lg p-4">
                    <div>
                        <h2 class="text-lg font-semibold">{{ $item['product']['name'] }}</h2>
                        <p class="text-white-600">${{ number_format($item['product']['price'], 2) }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <flux:button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" variant="outline">-</flux:button>
                        <span>{{ $item['quantity'] }}</span>
                        <flux:button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" variant="outline">+</flux:button>
                        <flux:button wire:click="removeItem({{ $item['id'] }})" variant="danger">Remove</flux:button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            <flux:button wire:click="checkout" variant="primary">Checkout</flux:button>
        </div>
    @endif
</div>
