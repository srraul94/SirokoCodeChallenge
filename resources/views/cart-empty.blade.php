<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Siroko Code Challenge" />
    <meta name="author" content="Raúl Sánchez" />
    <title>Siroko Shop - Cart Empty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="/">Siroko Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
            </ul>
            <form class="d-flex">
                <a class="btn btn-outline-dark" href="{{ route('cart-checkout',['cart_id' => $cart ?? null]) }}">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill" id="items-cart">0</span>
                </a>
            </form>
        </div>
    </div>
</nav>
<header class="bg-dark py-3">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Siroko Shop</h1>
            <p class="lead fw-normal text-white-50 mb-0">Siroko Code Challenge</p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row mb-5">
            <div class="text-center">
                <h1>Sorry! Your Cart is empty</h1>
            </div>
        </div>

        <div class="row mb-5">
            <div class="text-center">
                <a class="btn btn-success" href="/">Let's go shopping!</a>
            </div>
        </div>

    </div>
</section>

<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Raúl Sánchez Rubio 2023</p></div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script >

    const base_url = "{{ url('/') }}";

    $(document).ready(function (){
        getItemsOnCart();
    });

    function subQuantity(idProduct){

        let quantity = $("#quantity_"+idProduct).val();
        quantity = parseInt(quantity) - 1;

        let url = base_url + "/api/cart/update/" + idProduct;

        $.ajax({
            url: url,
            type: "PUT",
            dataType: "json",
            data: JSON.stringify({ "quantity": quantity }),
            contentType: "application/json",
            success: function(response) {
                window.location.reload();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonText: 'OK!',
                }).then((result) => {
                    window.location.reload();
                })

            }
        });
    }

    function addQuantity(idProduct){

        let quantity = $("#quantity_"+idProduct).val();
        quantity = parseInt(quantity) + 1;

        let url = base_url + "/api/cart/update/" + idProduct;

        $.ajax({
            url: url,
            type: "PUT",
            dataType: "json",
            data: JSON.stringify({ "quantity": quantity }),
            contentType: "application/json",
            success: function(response) {
                window.location.reload();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonText: 'OK!',
                }).then((result) => {
                    window.location.reload();
                })
            }
        });

    }

    function deleteProduct(idProduct){
        let url = base_url + "/api/cart/remove/" + idProduct;
        $.ajax({
            url: url,
            type: "DELETE",
            dataType: "json",
            // data: JSON.stringify({ "quantity": quantity }),
            contentType: "application/json",
            success: function(response) {
                window.location.reload();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonText: 'OK!',
                }).then((result) => {
                    window.location.reload();
                })
            }
        });
    }

    function getItemsOnCart(){
        let url = base_url + "/api/cart/total"

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                console.log(response);
                $("#items-cart").text(response.products);
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonText: 'OK!',
                }).then((result) => {
                    window.location.reload();
                })
            }
        });
    }

    function confirmPurchase(){
        let url = base_url + "/api/cart/confirm"

        $.ajax({
            url: url,
            type: "POST",
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Great!!',
                    text: 'Confirmed Purchase! Thank you!',
                    confirmButtonText: 'OK!',
                }).then((result) => {
                    window.location.href = "/";
                })
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonText: 'OK!',
                }).then((result) => {
                    window.location.reload();
                })
            }
        });
    }



</script>
</body>
</html>
