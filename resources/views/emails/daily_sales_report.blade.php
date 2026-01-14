<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales Report</title>
</head>
<body>
    <h1>Daily Sales Report for {{ $reportData['date'] }}</h1>
    <p>Total Sales: ${{ number_format($reportData['total_sales'], 2) }}</p>
    <p>Total Items Sold: {{ $reportData['total_items'] }}</p>
    <h2>Orders:</h2>
    <ul>
        @foreach($reportData['orders'] as $order)
            <li>
                Order #{{ $order->id }} - ${{ number_format($order->total, 2) }}
                <ul>
                    @foreach($order->orderItems as $item)
                        <li>{{ $item->product->name }} - Quantity: {{ $item->quantity }} - ${{ number_format($item->price, 2) }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</body>
</html>
