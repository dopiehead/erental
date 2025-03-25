<?php 
$product_id = $product['product_id'] ?? "N/A";
$poster_id = $product['poster_id'] ?? "N/A";
$poster_type = $product['poster_type'] ?? "N/A";
$product_name = $product['product_name'] ?? "N/A";
$product_price = isset($product['product_price']) ? (float) $product['product_price'] : 0;
$product_image = $product['product_image'] ?? "N/A";
$product_details = $product['product_details'] ?? "N/A";
$product_category = $product['product_category'] ?? "N/A";
$product_condition = $product['product_condition'] ?? "N/A";
$product_location = $product['product_location'] ?? "N/A";
$product_address = $product['product_address'] ?? "N/A";
$product_color = $product['product_color'] ?? "N/A";
$quantity_sold = $product['quantity_sold'] ?? "N/A";
$product_quantity = $product['product_quantity'] ?? "N/A";
$gift_picks = $product['gift_picks'] ?? "N/A";
$sold = $product['sold'] ?? "N/A";
$product_views = $product['product_views'] ?? "N/A";
$product_likes = $product['product_likes'] ?? "N/A";
$product_rating = $product['product_rating'] ?? "N/A";
$product_discount = isset($product['product_discount']) ? (float) $product['product_discount'] : 0;
$discountedPrice = $product_price > 0 && $product_discount > 0 
    ? $product_price - (($product_discount / 100) * $product_price) 
    : $product_price;
$featured_product = $product['featured_product'] ?? "N/A";
$date_added = $product['date_added'] ?? "N/A";
?>
