<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Print</title>
</head>
<body>

<table id="dt" class="datatables-basic1 table">
    <thead>
    <tr>
        <th>{{ __('modules/product.name') }}</th>
        <th>{{ __('modules/product.price') }}</th>
        <th>{{ __('modules/product.quantity') }}</th>
        <th>{{ __('modules/product.category') }}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <th>{{ $product->name }}</th>
            <th>{{ $product->price }}</th>
            <th>{{ $product->quantity }}</th>
            <th>{{ $product->category?->name }}</th>
        </tr>
    @empty
        <x-datatable.empty/>
    @endforelse
    </tbody>
</table>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
<script>
    window.print();
</script>
</body>
</html>
