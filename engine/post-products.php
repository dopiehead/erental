<?php 
session_start();
require 'config.php';
$user_id = $_SESSION['user_id'];
error_reporting(E_ALL ^ E_NOTICE);

// Variables defined according to your list:
$poster_id = $user_id; // User ID of the poster
$poster_type = trim($_POST['poster_type']); // Set this according to your application (e.g., "seller", "admin", etc.)
$product_name = trim($_POST['product_name']);
$product_price = trim($_POST['product_price']);
$product_image = ""; // Initially empty, will be populated during image upload
$product_details = trim($_POST['product_details'] ?? '');

// Additional fields:
$product_category = trim($_POST['product_category']);
$product_condition = trim($_POST['product_condition']);
$product_location = trim($_POST['product_location']);
$product_address = trim($_POST['product_address']);
$product_color = trim($_POST['product_color'] ?? '');
$quantity_sold = 0; // Default value; update as per requirements
$product_quantity = trim($_POST['quantity']);
$gift_picks = trim($_POST['gift_picks'] ?? '');
$sold = trim($_POST['sold'] ?? '');
$product_views = trim($_POST['views'] ?? '');
$product_likes = trim($_POST['likes'] ?? '');
$product_rating = 0; // Default value, set based on ratings logic
$product_discount = trim($_POST['discount'] ?? '');
$featured_product = trim($_POST['featured'] ?? '');
$product_date = date("Y-m-d H:i:s"); // Timestamp when product is added
$status = isset($_POST['status']) ? intval($_POST['status']) : 0; // Status (0 or 1)
$status = $status == 1 ? 0 : 1; // Toggle status value

// Ensure phone number is a valid integer
$phone_number = ctype_digit($_POST['phone_number']) ? (int) $_POST['phone_number'] : 0;

// Validate required fields
if (empty($product_name) || empty($product_details) || empty($product_price) || empty($product_location) || empty($phone_number)) { 
    die("All fields are required.");
}

if (strlen($product_name) > 20) {
    die("Item name limit exceeded, must be at most 20 characters.");
}

// Handle Image Upload
$imageFolder = "uploads/";
$basename = basename($_FILES["imager"]["name"]);
$imagePath = $imageFolder . $basename;
$file_extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
$allowed_extensions = ["jpg", "jpeg", "png"];
$maxsize = 5 * 1024 * 1024; // 5MB
$image_temp_name = $_FILES["imager"]["tmp_name"];
$imageSize = $_FILES["imager"]["size"];

// Image validation
if (!file_exists($image_temp_name)) {
    die("Choose an image file to upload.");
} elseif (!in_array($file_extension, $allowed_extensions)) {
    die("Please upload a valid image (PNG or JPEG only).");
} elseif ($imageSize > $maxsize) {
    die("Image file size limit exceeded. Please upload an image under 5MB.");
}

// Move the uploaded image
if (!move_uploaded_file($image_temp_name, $imagePath)) {
    die("Image upload failed.");
}

// Check for duplicate product
$check_query = "SELECT * FROM products WHERE product_name = ? AND product_details = ? AND poster_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ssi", $product_name, $product_details, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("You cannot post the same content twice.");
}
$stmt->close();

// Insert new product
$insert_query = "INSERT INTO products 
    (poster_id, poster_type, product_name, product_price, product_image, product_details, product_category, product_condition, product_location, product_address, product_color, quantity_sold, product_quantity, gift_picks, sold, product_views, product_likes, product_rating, product_discount, featured_product, product_date, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($insert_query);
$stmt->bind_param("isssssssssissiiiisisi", 
    $poster_id, $poster_type, $product_name, $product_price, $imagePath, $product_details, $product_category, $product_condition, $product_location, $product_address, $product_color, $quantity_sold, $product_quantity, $gift_picks, $sold, $product_views, $product_likes, $product_rating, $product_discount, $featured_product, $product_date, $status);

if ($stmt->execute()) {
    echo "1"; // Success
} else {
    echo "Item was not posted.";
}

$stmt->close();
$conn->close();
?>
