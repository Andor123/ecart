<div>
    <h1 class="text-2xl font-bold mb-4">Products</h1>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                <p class="text-white-600">${{ number_format($product->price, 2) }}</p>
                <p class="text-sm text-white-500">Stock: {{ $product->stock_quantity }}</p>
                <flux:button wire:click="addToCart({{ $product->id }})" class="mt-2" variant="primary">Add To Cart</flux:button>
                @if ($product->stock_quantity == 0)
                    <flux:button wire:click="removeItem({{ $product->id }})" class="mt-2" variant="danger">Remove</flux:button>
                @endif
            </div>
        @endforeach
    </div>
</div>
