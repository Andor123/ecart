<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Notification</title>
</head>
<body>
    <h1>Low Stock Alert</h1>
    <p>The product "{{ $product->name }}" is running low on stock.</p>
    <p>Current stock: {{ $product->stock_quantity }}</p>
    <p>Please restock soon.</p>
</body>
</html>
