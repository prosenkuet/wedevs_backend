<html>
<head>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <table class="table">
        @foreach($products as $product)
            <tr>
                <td>{{$product->title}}</td>
                <td>{{$product->description}}</td>
                <td><img src="{{asset('uploads/product/1615811918.png')}}"></td>
            </tr>
        @endforeach
        </table>

        <example-component/>
    </div>
</body>
</html>
