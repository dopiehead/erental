<?php
session_start();
require("config.php"); // Assuming this contains the connection as $conn

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract the data from the $_POST array
    $product = $_POST; // Assuming the form sends the product details in the POST array

    // Fetch the product details from the POST array
    $product_id = $product['product_id'];
    $poster_id = isset($product['poster_id']) && !empty($product['poster_id']) ? $product['poster_id'] : "N/A";
    $poster_type = isset($product['poster_type']) && !empty($product['poster_type']) ? $product['poster_type'] : "N/A";
    $product_name = $product['product_name'];
    $product_rating = $product['product_rating'];
    $product_price = $product['product_price'];
    $product_details = $product['product_details'];
    $product_category = $product['product_category'];
    $product_location = $product['product_location'];
    $product_address = $product['product_address'];
    $product_color = $product['product_color'];
    $quantity_sold = $product['quantity_sold'];
    $product_views = $product['product_views'];
    $product_likes = $product['product_likes'];
    $discountPercentage = max(0, min(100, (float)$product['product_discount']));
    $originalPrice = max(0, (float)$product['product_price']);
    $quantity = $product['product_quantity'];
    $discountAmount = ($discountPercentage / 100) * $originalPrice;
    $discountedPrice = $originalPrice - $discountAmount;
    $featured_product = $product['featured_product'];
    $product_date = $product['date_added'];

    // Handling multiple image uploads
    $uploaded_images = [];
    if (isset($_FILES['product_images'])) {
        $images = $_FILES['product_images'];

        // Loop through all the uploaded files
        foreach ($images['name'] as $key => $image_name) {
            // Check for errors during upload
            if ($images['error'][$key] === 0) {
                // Validate file size (Max size: 5MB)
                if ($images['size'][$key] < 5000000) {
                    // Get file extension
                    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

                    // Validate image extension
                    if (in_array($image_ext, $allowed_exts)) {
                        // Generate a unique name for the image and move the file to the uploads folder
                        $image_new_name = uniqid('', true) . "." . $image_ext;
                        $image_upload_path = "uploads/" . $image_new_name;

                        // Move the uploaded file to the 'uploads' directory
                        if (move_uploaded_file($images['tmp_name'][$key], $image_upload_path)) {
                            // Successfully uploaded image, add to the list of uploaded images
                            $uploaded_images[] = $image_new_name;
                        } else {
                            echo "Failed to upload one or more images.";
                            exit;
                        }
                    } else {
                        echo "Invalid image type. Only JPG, JPEG, PNG, and GIF files are allowed.";
                        exit;
                    }
                } else {
                    echo "One of the images is too large. Maximum size allowed is 5MB.";
                    exit;
                }
            } else {
                echo "Error uploading one of the images. Please try again.";
                exit;
            }
        }
    } else {
        echo "No images uploaded.";
        exit;
    }

    // Convert the array of image names to a comma-separated string
    $product_images = implode(",", $uploaded_images);

    // Prepare the SQL INSERT statement
    $sql = "INSERT INTO products (
                product_id, 
                poster_id, 
                poster_type, 
                product_name, 
                product_rating, 
                product_price, 
                product_images, 
                product_details, 
                product_category, 
                product_location, 
                product_address, 
                product_color, 
                quantity_sold, 
                product_views, 
                product_likes, 
                product_discount, 
                product_quantity, 
                featured_product, 
                date_added
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the statement
        $stmt->bind_param(
            "ssssdsdsssssiiisdsd", 
            $product_id, 
            $poster_id, 
            $poster_type, 
            $product_name, 
            $product_rating, 
            $product_price, 
            $product_images, 
            $product_details, 
            $product_category, 
            $product_location, 
            $product_address, 
            $product_color, 
            $quantity_sold, 
            $product_views, 
            $product_likes, 
            $discountPercentage, 
            $quantity, 
            $featured_product, 
            $product_date
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "Product uploaded successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare the SQL statement.";
    }
} else {
    echo "Invalid request method!";
}
?>
