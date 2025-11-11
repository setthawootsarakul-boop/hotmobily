<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายการสินค้า</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        .card { border: 1px solid #ccc; padding: 1rem; margin-bottom: 1rem; border-radius: 10px; }
        h2 { color: #a00; }
        img { max-width: 150px; border-radius: 8px; }
    </style>
</head>
<body>
    <h1>รายการสินค้า</h1>

    @foreach ($products as $product)
        <div class="card">
            <h2>{{ $product->name }}</h2>
            <p>หมวดหมู่: {{ $product->category->name ?? '-' }}</p>
            <p>{{ $product->description }}</p>

            @if ($product->images->count())
                <div>
                    @foreach ($product->images as $img)
                        <img src="{{ $img->image_url }}" alt="{{ $img->alt_text }}">
                    @endforeach
                </div>
            @endif

            <h4>ราคาต่อหน่วย:</h4>
            <ul>
                @foreach ($product->prices as $p)
                    <li>{{ $p->quantity_min }}-{{ $p->quantity_max }} ชิ้น: {{ $p->price_per_unit }} บาท</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</body>
</html>
