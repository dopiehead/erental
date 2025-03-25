<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    require("../engine/config.php");
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_details = $_POST['product_details'];
    $product_color = $_POST['product_color'];
    $discountPercentage = $_POST['discountPercentage'];
    $quantity = $_POST['quantity'];
    $product_image = $_FILES['product_image']; // Handle image upload

    // Handle image upload (optional, based on your needs)
    if ($product_image['error'] == 0) {
        $imagePath = 'uploads/' . basename($product_image['name']);
        move_uploaded_file($product_image['tmp_name'], $imagePath);
    } else {
        $imagePath = $_POST['existing_product_image']; // Use existing image if no new image uploaded
    }

    // Prepare the SQL query to update the product
    $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_price = ?, product_details = ?, product_color = ?, discountPercentage = ?, quantity = ?, product_image = ? WHERE product_id = ?");
    $stmt->bind_param("sssssisi", $product_name, $product_price, $product_details, $product_color, $discountPercentage, $quantity, $imagePath, $product_id);

    if ($stmt->execute()) {
        echo 1; // Success
    } else {
        echo "Error updating product: " . $stmt->error; // Show error message
    }

    $stmt->close();
    $conn->close();
}
?>

