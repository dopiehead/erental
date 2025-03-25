<?php session_start(); 
require("engine/config.php");

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $buyer = $_SESSION['user_id'];
    $getbuyer = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
    $getbuyer->bind_param("i", $buyer); // "i" denotes an integer parameter
    $getbuyer->execute();
    $result = $getbuyer->get_result();

    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            include("contents/user-contents.php");
        }
    }
    $getbuyer->close(); // Close the prepared statement
} else {
    $buyer = null;
}

if (isset($_GET['id'])) {
    $productid = ($_GET['id']); // Decode the product ID

    if (empty($productid)) {

        header("Location:index.php");
        exit; 
    }

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $productid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($product = $result->fetch_assoc()) {
        $stmt2 = $conn->prepare("UPDATE products SET product_views = product_views + 1 WHERE product_id = ?");
        $stmt2->bind_param("i", $productid);
        $stmt2->execute();
        include("contents/product-contents.php");  
        $stmt_poster = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
        $stmt_poster->bind_param("i", $poster_id);
        $stmt_poster->execute();
        $result_x = $stmt_poster->get_result();
        $seller = $result_x->fetch_assoc();
        include("contents/seller-contents.php");
        $extension = strtolower(pathinfo($seller_details_image, PATHINFO_EXTENSION));
        $image_extension = array('jpg', 'jpeg', 'png');
        
          
    } else {
 
        echo "<h1>Product not found</h1>";
        header("Location: index.php");
        exit;
    }
} else {
    
    echo "<h1>Product ID not provided</h1>";
    header("Location: index.php");
    exit; 
}
?>

<html lang="en">
<head>
    <?php include("components/links.php") ?>
    <link rel="stylesheet" href="assets/css/product-details.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Product Details</title>
</head>
<body>

    <?php include("components/navbar.php") ?>
    <!-- Header Section -->
    <div class="container-fluid red-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="products.php?category=<?= htmlspecialchars(preg_replace("/_/"," ",$product_category)) ?>" class="text-white">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= htmlspecialchars(preg_replace("/_/"," ",$product_category)) ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Section -->
    <div class="container mt-4">
        <div class="d-flex gap-3 flex-md-row flex-column">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($product_image) ?>" alt="<?= htmlspecialchars($product_name) ?>" class="product-image img-fluid">
            </div>
            <div class="col-md-6">
                <h1 class="text-capitalize"><?= htmlspecialchars(preg_replace("/_/"," ",$product_name)) ?> - <span class='text-sm text-muted'><a href='store.php?id=<?=htmlspecialchars($poster_id) ?>'><?= htmlspecialchars($seller_details_name) ?></a></span></h1>
                <div class="rating mb-2">
                    <span class="text-warning">
                        <?php 

                           if($product_rating > 0 && $product_rating < 20){
                                 echo "<span class='fas fa-star'></span><span class='fas fa-star'></span><span class='fas fa-star'></span><span class='fas fa-star'></span><span class='fas fa-star'></span>";
                           }
                           elseif($product_rating>20 && $product < 50){
                                  echo "<span class='fas fa-star text-warning'></span><span class='fas fa-star '></span><span class='fas fa-star'></span><span class='fas fa-star'></span><span class='fas fa-star'></span>";                          
                           }
                           elseif($product_rating>50 && $product_rating < 100){
                                 echo "<span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span>";                          
                           }

                          ?>
                    </span>
                    <span class="text-muted">(4.5)</span>
                </div>

                <div class="price mb-3">
                    <?php if ($discountPercentage > 0): ?>
                        <del class="text-muted me-2">₦<?= htmlspecialchars($discountedPrice) ?></del>
                        ₦<?= htmlspecialchars($discountedPrice) ?> <span class="badge bg-danger"><?= htmlspecialchars($discountPercentage) ?>% OFF</span>
                    <?php else: ?>
                        <i class="fas fa-naira-sign"></i> <?= htmlspecialchars(number_format($product_price,2)); ?>
                    <?php endif; ?>
                </div>

                <p class="text-muted">
                    Glare optimal tools ecological task per per use inexpensive per inevitability.
                    Interior fusion clean, constant management publisher.
                </p>

                <div class="share-icons mb-3">
                    <a href="#" class="text-decoration-none"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-decoration-none"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-decoration-none"><i class="fab fa-pinterest"></i></a>
                    <a href="#" class="text-decoration-none"><i class="fab fa-instagram"></i></a>
                </div>

                <div class="d-flex align-items-center">
                    <div class="d-flex gap-1 me-3">
                        <button id="subs" onclick="subst()" class="btn btn-outline-secondary">-</button>
                        <input type="number" class="onlyNumber px-1 w-25 border border-mute "  
                          max="<?= htmlspecialchars($quantity); ?>" 
                         id="noofitem" 
                         value="<?php if(!empty($quantity)): echo htmlspecialchars($quantity);  endif; ?>" 
                         name="noofitem" 
                         min="1">

                        <button id="adds" onclick="add()" class="btn btn-outline-secondary">+</button>
                    </div>
                     
                    <?php if ($_SESSION['user_id'] !== ''): ?>
                    <?php if ($_SESSION['user_id'] == $poster_id): ?>
                          <a class="btn btn-success text-white flex-grow-1">You posted this Item</a>
                     <?php else: ?>
                         <button id='<?= htmlspecialchars($productid)?>' class="btn btn-success btn-add flex-grow-1">Rent</button>
                     <?php endif; ?>
                     <?php else: ?>
                          <a href='sign-in.php?details=<?= htmlspecialchars(urlencode($_SERVER['REQUEST_URI'])) ?>' class="btn btn-success flex-grow-1 text-white">Add to Cart</a>
                      <?php endif; ?>

                </div>
                <div class="mt-3">
                    <span class="text-muted">Category: </span>
                    <a href="products.php?category=<?= htmlspecialchars(preg_replace("/_/"," ",$product_category)) ?>" class="text-decoration-none"><?= htmlspecialchars(preg_replace("/_/"," ",$product_category)) ?></a>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="row mt-4 bg-success w-100 py-2">
            <div class="col">
                <nav>
                    <ul class="nav nav-tabs text-center" id="productTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="owner-tab" data-bs-toggle="tab" data-bs-target="#owner" role="tab">Product Owner</a>
                        </li>
                        <li class="nav-item text-white">
                            <a class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback" role="tab">Customer Feedback</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
 <br><br>
    <!-- Tab Contents -->
    <div class="container mt-3">
        <div class="tab-content" id="productTabsContent">
            <!-- Product Details Section -->
            <div class="tab-pane fade show active" id="description" role="tabpanel">
                <div class="d-flex justify-content-center container flex-md-row flex-column gap-3">
                    <div class="w-100">
                        <p class="text-muted"><?= htmlspecialchars($product_details); ?></p>
                    </div>
                    <div class="w-100">
                        <img style='width:250px;' src="<?= htmlspecialchars($product_image); ?>" alt="<?= htmlspecialchars($product_name); ?>" class="product-image img-fluid mb-3">
                        <div class="d-flex justify-content-between">
                            <?php if ($discountPercentage > 0): ?>
                                <span class="badge bg-danger"><?= htmlspecialchars($discountPercentage); ?>% Discount</span>
                            <?php endif; ?>
                            <span class="badge badge-organic">100% Organic</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Owner Section -->
            <div class="tab-pane fade" id="owner" role="tabpanel">
                <?php 
                $stmt_poster = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
                $stmt_poster->bind_param("i", $poster_id);
                $stmt_poster->execute();
                $result_x = $stmt_poster->get_result();
                while ($seller = $result_x->fetch_assoc()) {
                    include("contents/seller-contents.php");
                    $extension = strtolower(pathinfo($seller_details_image, PATHINFO_EXTENSION));
                    $image_extension = array('jpg', 'jpeg', 'png');
                }
                ?>
                <div class="container d-flex align-items-center flex-md-row flex-column gap-3 p-3">
                    <div class="col-md-6">
                        <?php 
                        if (!in_array($extension, $image_extension)) {
                            echo "<div class='text-center'><span class='text-secondary text-uppercase' style='font-size:120px;'>".substr($seller_details_name, 0, 2)."</span></div>"; 
                        } else { ?>
                            <img class="user_img" style="border-radius:15px; object-fit:cover;" src="<?= htmlspecialchars($seller_details_image); ?>" alt="<?= htmlspecialchars($seller_details_name) ?>">
                        <?php } ?>
                    </div>
                    <div class="d-flex flex-column col-md-6">
                        <span class="text-capitalize fw-bold text-dark"><?= htmlspecialchars($seller_details_name) ?></span>
                        <span class="text-sm text-muted"><?= htmlspecialchars($seller_details_address) ?>, <?= htmlspecialchars($seller_details_location) ?></span>
                        <span class="text-sm text-muted"><?= htmlspecialchars($seller_details_type) ?></span>
                    </div>
                </div>
            </div>
            <!-- Reviews and Comments Section -->
            <div class="tab-pane fade" id="feedback" role="tabpanel">
                <div class="d-flex flex-column flex-md-row">
                    <div class="comment-container col-md-6">
                        <ul class="nav nav-tabs" id="commentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" type="button" role="tab">Comment</button>
                            </li>
                            <li class="nav-item ms-auto" role="presentation">
                                <button class="nav-link" id="report-tab" data-bs-toggle="tab" data-bs-target="#report" type="button" role="tab">Report an issue</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="commentTabsContent">
                            <div class="tab-pane fade show active" id="comment" role="tabpanel">
                                <form id="comment-form">
                                    <div class="mb-3">
                                        <input name="product_name" type="hidden" value="<?= htmlspecialchars($product_name); ?>">
                                        <input name="sender_email" type="hidden" value="<?= htmlspecialchars($email) ?>">
                                        <input name="sender_name" type="hidden" value="<?= htmlspecialchars($name) ?>">
                                        <textarea name="comment" class="form-control" placeholder="Your comment" rows="8"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <?php if(isset($_SESSION['email']) && $_SESSION['email'] !== $seller_details_email){ ?>
                                             <button type="submit" class="btn btn-add-comment">Add comment</button>
                                        <?php } else { ?>
                                             <a href="sign-in.php?details=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-add-comment">Add comment</a>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="report" role="tabpanel">
                                <!-- Report Tab Content -->
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="comment-container col-md-6">
                    <?php

$getcomment = $conn->prepare(
    "SELECT 
        user_profile.user_name AS user_name, 
        user_profile.user_email AS user_email, 
        user_profile.user_image AS user_image,
        seller_comment.id AS id,
        seller_comment.sender_email AS sender_email, 
        seller_comment.comment AS comment, 
        seller_comment.product_name AS product_name,
        seller_comment.date AS date
    FROM user_profile
    INNER JOIN seller_comment ON seller_comment.sender_email = user_profile.user_email
    WHERE seller_comment.product_name =  ?"
);

$getcomment->bind_param("s", $product_name);

$getcomment->execute();

$comment_result = $getcomment->get_result();

while ($comment = $comment_result->fetch_assoc()) {

    
    $comment_time = strtotime($comment['date']);
    
    $time_diff = time() - $comment_time;

    if ($time_diff < 60) {
        $time_ago = "Just now";
    } elseif ($time_diff < 3600) {
        $time_ago = floor($time_diff / 60) . " minutes ago";
    } elseif ($time_diff < 86400) {
        $time_ago = floor($time_diff / 3600) . " hours ago";
    } else {
        $time_ago = floor($time_diff / 86400) . " days ago";
    }
    ?>

    <div class="comment">
        <div class="avatar">
            <img src="<?= htmlspecialchars($comment['user_image']) ?>" alt="<?= htmlspecialchars($comment['product_name']) ?>">
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <span class="commenter-name"><?= htmlspecialchars($comment['user_name']) ?></span>
                <span class="comment-time"><?= $time_ago ?></span>
            </div>
            <p class="comment-text"><?= htmlspecialchars($comment['comment']) ?></p>
        </div>
    </div>
<?php
}

?>    
     <input type="hidden" name='seller_id' id='seller_id' value="<?= htmlspecialchars($poster_id); ?>">
    <input type="hidden" name='seller_type' id='seller_type' value="<?= htmlspecialchars($seller_details_type); ?>">
    <input type="hidden" name='buyer' id='buyer' value="<?= htmlspecialchars($buyer); ?>">

                    </div>
                </div>
            </div>
        </div>
    </div>
<br><br>

    <!-- Footer -->
    <?php include("components/footer.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src='assets/js/add_comment.js'></script>
    <script src='assets/js/add_to_cart.js'></script>
    <script src='assets/js/add_to_report.js'></script>

</body>
</html>