<?php 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    require("../engine/config.php");

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($product = $result->fetch_assoc()) {
            include("../contents/product-contents.php");
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Edit Product</h4>
                </div>
                <div class="card-body">
                    
                 <form method="POST" id="edit-form">
                    <!-- Image upload section -->
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Product Image</label>
                        <input name="product_image" type="file" class="form-control" value="<?= htmlspecialchars($product['product_image']) ?>" id="product_image">
                    </div>

                    <!-- Edit form -->
               
                        <!-- Product name -->
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" class="form-control" id="product_name" required>
                        </div>

                        <!-- Product ID (hidden) -->
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">

                        <!-- Product price -->
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Product Price</label>
                            <input type="number" name="product_price" value="<?= htmlspecialchars($product['product_price']) ?>" class="form-control" id="product_price" required>
                        </div>

                        <!-- Product details -->
                        <div class="mb-3">
                            <label for="product_details" class="form-label">Product Details</label>
                            <textarea name="product_details" class="form-control" id="product_details" rows="4" required><?= htmlspecialchars($product['product_details']) ?></textarea>
                        </div>

                        <!-- Product color -->
                        <div class="mb-3">
                            <label for="product_color" class="form-label">Product Color</label>
                            <input type="text" name="product_color" value="<?= htmlspecialchars($product['product_color']) ?>" class="form-control" id="product_color" required>
                        </div>

                        <!-- Discount percentage -->
                        <div class="mb-3">
                            <label for="discountPercentage" class="form-label">Discount Percentage</label>
                            <input type="number" min="0" max="100" maxlength="3" name="discountPercentage" value="<?= htmlspecialchars($product['product_discount']) ?>" class="form-control" id="discountPercentage" required>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" min='0' value="<?= htmlspecialchars($product['product_quantity']) ?>" class="form-control" id="quantity" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between gap-3">
                            
                                
                                <a class='btn btn-primary text-white form-control ' onclick='window.history.go(-1)'>Go back</a>
                                 <button name='submit' type="submit" class="btn btn-success btn-submit form-control">
                                     <span class="submit-note"></span>Submit
                                     <span class="spinner-border spinner-border-sm text-light" style="display:none;"></span>
                                </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
        }
    }
}
?>

<script>
$(document).ready(function(){
    $(".spinner-border").hide();
    $(".btn-submit").on("click",function(e){
        e.preventDefault();
        $(".submit-note").hide();
        $(".spinner-border").show(); // Show spinner when submitting

        let formData = new FormData($("#edit-form")[0]); // Use FormData to handle file upload
        $.ajax({
            url: "edit-product.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $(".spinner-border").hide(); // Hide spinner after response
                if(response == 1){
                    $("#result").html("Update was successful");
                } else {
                    $("#result").html(response); // Show error message if any
                }
            },
            error: function(err){
                $(".spinner-border").hide(); // Hide spinner if an error occurs
                console.log(err);
            }
        });
    });
});
</script>


<!-- Include Bootstrap JS and CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>