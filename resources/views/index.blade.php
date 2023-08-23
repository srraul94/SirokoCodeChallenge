<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Siroko Code Challenge" />
    <meta name="author" content="Raúl Sánchez" />
    <title>Siroko Shop</title>
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
                <a class="btn btn-outline-dark" id="cart-href" href="{{ route('cart-checkout',['cart_id' => $cart ?? null]) }}">
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
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach($products as $product)
                <div class="col mb-5">
                    <div class="card h-100">
                        <img class="card-img-top" src="{{$product->productImage}}" alt="product" />
                        <div class="card-body p-4">
                            <div class="text-center">

                                <h5 class="fw-bolder">{{$product->name}}</h5>
                                <span>{{$product->price}} €</span>
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center ">
                                <label>Quantity</label>
                                <input class=" form-control mb-3" value="1" placeholder="Select Quantity" type="number" id="quantity-{{$product->id}}" />
                            </div>
                            <div class="text-center">

                                <button class="btn btn-outline-dark mt-auto" onclick="addToCart({{$product->id}})">Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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

    function addToCart(idProduct){
        let quantity = $("#quantity-"+idProduct).val();
        let url = base_url + "/api/cart/add/" + idProduct;

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: JSON.stringify({ "quantity": quantity }),
            contentType: "application/json",
            success: function(response) {
                console.log("Producto añadido al carrito:", response);
                $("#quantity-"+idProduct).val(1);
                getItemsOnCart();
            },
            error: function(error) {
                console.error("Error al añadir producto al carrito:", error);
            }
        });

    }

    function getItemsOnCart(){
        let url = base_url + "/api/cart/total"

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $("#items-cart").text(response.products);
            },
            error: function(error) {
                console.error("Error al añadir producto al carrito:", error);
            }
        });
    }

</script>
</body>
</html>
