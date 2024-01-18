<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Load Bootstrap JS with Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <style>
        .modal-dialog {
            max-width: 50%;
            margin: 30px auto;
        }

        .card {
            width: 280px;
            height: 280px;
        }

        .img-card {
            width: 280px;
            height: 200px;
            margin-top: 25px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }


    </style>
</head>

<body>

    <div class="container mt-5">
    <h1 class="mt-5 mb-5">Products</h1>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-3 col-sm-12 col-md-4 mb-3">
                    <div class="card">
                    <div class="img-card">
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                            alt="Photo" class="img-fluid" data-toggle="modal" data-target="#myModal{{ $product->id }}"
                            data-product-id="{{ $product->id }}">
                    </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">₱ {{ $product->price }}.00</p>
                            <a href="/products/{{ $product->id }}" class="btn btn-warning">Order Item</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No products yet!</p>
            @endforelse
        </div>
    </div>

    <!-- The Modal -->
    @forelse ($products as $product)
        <div class="modal fade" id="myModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="Larger Photo" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No products yet!</p>
    @endforelse

    <script>
        // Update the modal target based on the clicked product's ID
        $('.card img').on('click', function() {
            let productId = $(this).data('product-id');
            $('#myModal' + productId).modal('show');
        });
    </script>

</body>

</html>
