<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .modal-dialog {
            max-width: 80%;
            margin: 30px auto;
        }

        .card {
            padding: 50px;
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
        }

        img {
            margin-top: 25px;
            max-width: 200px;
            width: 200px;
        }

    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>{{$product->name}}</h1>
        <div class="row">
            <div class="card col-5" style="width: 15rem;">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Photo"
                    class="img-fluid" data-toggle="modal" data-target="#myModal">
            </div>
            <div class="card col-6 pr-2">
                <form method="POST" action="/orders" id="buyForm">
                    @csrf
                    <div class="row col-8">
                        <div class="form-group col-6">
                            <label for="exampleInputquantity1">Qty</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control"
                                id="exampleInputquantity1" aria-describedby="emailHelp">
                            @error('quantity')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    <div class="form-group col-6">
                        <label for="price">Price</label>
                        <span class="text-body-secondary" id="totalPrice"> ₱ {{ $product->price }}.00 </span>
                        <input type="hidden" id="price" name="price" value="{{ $product->price }}">
                    </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputBuyer1">Name of Buyer</label>
                        <input type="text" class="form-control" id="exampleInputBuyer1" name="buyer_name">
                        @error('buyer_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputBuyer1">Mobile Number</label>
                        <input type="number" name="mobile_number" class="form-control" id="exampleInputBuyer1">
                        @error('mobile_number')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <a href="/products" class="btn btn-warning mr-2">Cancel</a>
                    <button type="button" class="btn btn-primary" onclick="validateForm()">Buy</button>

                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                        aria-labelledby="confirmationModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="confirmationModalLabel">Are you sure?</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    Will you buy?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Modal -->
                    <div class="modal fade" id="successModal" tabindex="-1" role="dialog"
                        aria-labelledby="successModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="successModalLabel">Success!</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    Your order has been submitted successfully.
                                    SMS has been sent to user.
                                </div>
                                {{--  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                </div>  --}}
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Load Bootstrap JS with Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
    document.getElementById('quantity').addEventListener('input', function() {
        let quantity = parseInt(this.value, 10);

        if (isNaN(quantity) || quantity <= 0) {
            quantity = 1;
        }

        let price = parseFloat(document.getElementById('totalPrice').value);

        if (isNaN(price) || price <= 0) {
            price = {{ $product->price }};
        }

        const totalPrice = quantity * price;
        const displayedPrice = document.getElementById('totalPrice');

        displayedPrice.textContent = `₱ ${totalPrice.toFixed(2)}`;
        document.getElementById('price').value = totalPrice.toFixed(2);
    });


        function validateForm() {
            var quantityValue = document.getElementById('quantity').value.trim();
            var buyerNameValue = document.getElementById('exampleInputBuyer1').value.trim();
            var mobileNumberValue = document.getElementById('exampleInputBuyer1').value.trim();

            if (quantityValue === '' || buyerNameValue === '' || mobileNumberValue === '') {
                alert('Please fill in all required fields.');
            } else {
                $('#confirmationModal').modal('show');
            }
        }

       function submitForm() {
    // Use AJAX to submit the form without page reload
    $.ajax({
        url: '/orders',
        method: 'POST',
        data: $('#buyForm').serialize(),
        success: function (response) {
            // Assuming the server responds with success
            $('#confirmationModal').modal('hide');

            // Show the success modal after the page reloads
            $(document).ajaxStop(function () {
                $('#successModal').modal('show');
            });

            // Reload the page after a short delay
            setTimeout(function () {
                location.reload();
            }, 2000); // You can adjust the delay time (in milliseconds) as needed
        },
        error: function (error) {
            console.error(error);
            // Handle error response from the server if needed
        }
    });
}

    </script>
</body>

</html>
