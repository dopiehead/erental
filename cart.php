<?php session_start();
error_reporting(E_ALL ^ E_NOTICE);
$buyer = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("components/links.php"); ?>
    <title>My Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/cart.css" rel="stylesheet">
</head>
<body>
    <?php include("components/navbar.php"); ?>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="index.php" class="me-3"><i class="bi bi-house-door"></i> Home</a>
                <span>›</span>
                <a href="#" class="ms-2">My Cart</a>
            </div>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="container cart-container my-4">
        <h4 class="text-center mb-4">My Shopping Cart</h4>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>PRICE</th>
                                        <th>QUANTITY</th>
                                        <th>SUBTOTAL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if (!empty($buyer)) {
                                    require("engine/config.php");

                                    $cart_item = "SELECT cart.itemId, cart.seller_id, cart.noofItem, cart.buyer, 
                                                 products.product_id, products.product_name, products.product_image, 
                                                 products.product_price, products.product_discount, products.product_location 
                                          FROM cart 
                                          JOIN products ON cart.itemId = products.product_id 
                                          WHERE cart.buyer = ? AND cart.payment_status = 0";

                                    if ($stmt = mysqli_prepare($conn, $cart_item)) {
                                        mysqli_stmt_bind_param($stmt, "s", $buyer);
                                        mysqli_stmt_execute($stmt);
                                        $cart = mysqli_stmt_get_result($stmt);

                                        $total_price = 0;
                                        $VAT = 0;
                                        $delivery_fee = 7.54;

                                        if ($cart && mysqli_num_rows($cart) > 0) {
                                            while ($row = mysqli_fetch_assoc($cart)) {
                                                $product_id = $row['product_id'];
                                                $product_name = $row['product_name'];
                                                $noofItem = $row['noofItem'];
                                                $product_image = $row['product_image'];
                                                $product_price = $row['product_price'];
                                                $product_discount = $row['product_discount'];

                                                // Calculate price after discount
                                                $discounted_price = $product_price - ($product_price * ($product_discount / 100));
                                                $subtotal = $discounted_price * $noofItem;

                                                // Accumulate total price
                                                $total_price += $subtotal;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?= htmlspecialchars($product_image) ?>" alt="<?= htmlspecialchars($product_name) ?>" class="product-img me-3">
                                                            <span><?= htmlspecialchars($product_name) ?></span>
                                                        </div>
                                                    </td>
                                                    <td><i class='fas fa-naira-sign'></i> <?= htmlspecialchars(number_format($product_price, 0)) ?></td>
                                                    <td>
                                                        <div class="quantity-control">
                                                            <button class="btn" onclick="subst(this)" data-id="<?= $product_id ?>">-</button>
                                                            <input type="text" value="<?= $noofItem ?>" readonly>
                                                            <button class="btn" onclick="add(this)" data-id="<?= $product_id ?>">+</button>
                                                        </div>
                                                    </td>
                                                    <td><i class='fas fa-naira-sign'></i> <?= htmlspecialchars(number_format($subtotal, 0)) ?></td>
                                                    <td><span class="remove-btn" onclick="removeItem('<?= $product_id ?>')">×</span></td>
                                                </tr>
                                    <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="5" class="text-center">Your cart is empty</td></tr>';
                                        }
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center">Please login to view your cart</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="products.php" class="btn btn-light">Return to shop</a>
                    <button class="btn btn-light" id="updateCart">Update Cart</button>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart Total</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span><i class='fas fa-naira-sign'></i> <?= isset($total_price) ? htmlspecialchars(number_format($total_price, 0)) : '0' ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total:</span>
                            <span class="fw-bold"><i class='fas fa-naira-sign'></i> <?= isset($total_price) ? htmlspecialchars(number_format($total_price, 0)) : '0' ?></span>
                        </div>
                        <a href="checkout-page.php" class="cart-btn w-100 text-center text-decoration-none">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include("components/footer.php"); ?>
    
    <input type="hidden" id="buyer" value="<?= htmlspecialchars($buyer) ?>">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.numbering').load('engine/item-numbering.php');
        });
        
        function add(btn) {
            var itemId = $(btn).data('id'); 
            var buyer = $('#buyer').val();
            var qtyElem = $(btn).siblings('input');
            var a = parseInt(qtyElem.val());
            a++;

            $.ajax({
                type: "POST",
                url: "engine/add_to_cart.php",
                data: { 'buyer': buyer, 'itemId': itemId },
                success: function(response) {
                    qtyElem.val(a);
                    // Reload page to update totals
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("Error adding item: ", error);
                }
            });
        }

        function subst(btn) {
            var itemId = $(btn).data('id');
            var buyer = $('#buyer').val();
            var qtyElem = $(btn).siblings('input');
            var b = parseInt(qtyElem.val());

            if (b > 1) {
                b--;
                $.ajax({
                    type: "POST",
                    url: "engine/remove_from_cart.php",
                    data: { 'buyer': buyer, 'itemId': itemId },
                    success: function(response) {
                        qtyElem.val(b);
                        // Reload page to update totals
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error removing item: ", error);
                    }
                });
            }
        }
        
        function removeItem(itemId) {
            if (confirm('Are you sure you want to remove this item?')) {
                var buyer = $('#buyer').val();
                $.ajax({
                    type: "POST",
                    url: "engine/delete_from_cart.php",
                    data: { 'buyer': buyer, 'itemId': itemId },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error removing item: ", error);
                    }
                });
            }
        }
        
        $('#updateCart').click(function() {
            location.reload();
        });
    </script>
</body>
</html>