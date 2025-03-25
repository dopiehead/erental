<?php session_start();

if (isset($_GET['id'])) {
    require("engine/config.php");

    // Sanitize and validate the input id.
    $id = intval($_GET['id']);

    // Prepare and execute query to fetch user profile.
    $stmt = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        // Include additional user content.
        include("contents/user-contents.php");
        
        $extension = strtolower(pathinfo($user_image,PATHINFO_EXTENSION));
        $image_extension  = array('jpg','jpeg','png'); 
        
        // Prepare and execute query to get the seller's total product views.
        $get_seller_profile = $conn->prepare("SELECT SUM(product_views) AS views FROM products WHERE poster_id = ?");
        if (!$get_seller_profile) {
            die("Prepare failed: " . $conn->error);
        }
        $get_seller_profile->bind_param("i", $user['id']);
        $get_seller_profile->execute();
        $profileResult = $get_seller_profile->get_result();
        $profileData = $profileResult->fetch_assoc();
        $seller_views = $profileData['views'];
        $get_seller_profile->close();

        // You can now use $seller_views as needed.

    } else {
        // If no user is found, redirect.
        header("Location: product-details.php?id=" . base64_encode($id));
        exit();
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> 
    <?php include ("components/links.php"); ?>
    <link rel="stylesheet" href="assets/css/store.css">
    <link rel="stylesheet" href="assets/css/banner-signup.css">
    <title><?= htmlspecialchars($user_type) ?></title>

</head>
<body>
    <?php include ("components/navbar.php");?>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="row g-0">
                <div class="col-md-4">
                 <?php 
                 if (!in_array($extension , $image_extension)) {
                      echo"<div class='text-center'><span class='text-secondary text-uppercase' style='font-size:130px;'>".substr($user_name,0,2)."</span></div>";                 
                 } else { ?>   
                    <img src="<?= htmlspecialchars($user_image); ?>" alt="Store front" class="img-fluid rounded-start" style="object-fit: cover; height: 100%;">
                <?php } ?>
                    
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h2 class="card-title"><?=htmlspecialchars($user_name); ?>  <span class='fw-bold text-muted text-sm'> - <?= htmlspecialchars($user_type); ?></span></h2>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-location-dot me-2"></i>
                                    <?if($user_address!==''){ ?>
                                    <?= htmlspecialchars($user_address); ?>
                                    <?php } else { ?>
                                     <span class='text-secondary text-sm '>No location enlisted yet.</span>
                                    <?php } ?>
                                </p>
                            </div>
                            <?php if($user_rating > 0 ): ?>
                            <div class="d-flex align-items-center">

                                <div class="text-warning me-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-muted">4.34</span>
                            </div>
                           <?php endif; ?>


                        </div>
                        
                        <div class="mt-3">
                           
                           <p class="mb-1">
                              <?php if (isset($user_phone) && $user_phone !== "") { ?>
                                   <a class='text-secondary text-decoration-none' href='tel:<?= htmlspecialchars($user_phone) ?>'>
                                      <i class="fas fa-phone me-2"></i>
                                      <?= htmlspecialchars($user_phone); ?>
                                  </a>
                              <?php } else { ?>
                               <i class="fas fa-phone me-2 text-sm"></i> : <span class='text-secondary text-sm'>No phone number available yet.</span>
                             <?php } ?>
                         </p>

                         <p class="mb-2">
                          <?php if (isset($user_email) && $user_email !== "") { ?>
                             <a class='text-dark text-decoration-none' href='mailto:<?= htmlspecialchars($user_email) ?>'>
                               <i class="fas fa-envelope me-2"></i>
                               <?= htmlspecialchars($user_email); ?>
                             </a>
                         <?php } else { ?>
                            <i class="fas fa-envelope me-2"></i> : <span class='text-secondary text-sm'>No email available yet.</span>
                         <?php } ?>
                         </p>

                         <p class="mb-2">
                          <?php if (isset($user_phone) && $user_phone !== "") { ?>
                          <a class='text-dark text-decoration-none' href="https://wa.me/+234<?= htmlspecialchars($user_phone) ?>?text=Hello%20I%20want%20to%20order%20Food%20." target="_blank">
                          <span class="fab fa-whatsapp me-2 text-success"></span>
                          <?= htmlspecialchars($user_phone); ?>
                          </a>
                         <?php } else { ?>
                         <i class="fab fa-whatsapp me-2"></i> : <span class='text-secondary text-sm'>No WhatsApp link available yet.</span>
                         <?php } ?>
                         </p>

                        </div>

                        <div class="mt-3">
                            <a href='products.php?search=drink' class="badge bg-secondary me-2 text-decoration-none text-white">Drink</a>
                            <a href='products.php?search=soft drink' class="badge bg-secondary me-2 text-decoration-none text-white">Soft drink</a>
                            <a href='products.php?search=yellow' class="badge bg-secondary me-2 text-decoration-none text-white">Yellow</a>
                            <a href='products.php?search=fruits' class="badge bg-secondary me-2 text-decoration-none text-white">Fruit</a>
                            <a href='products.php?seach=cheap' class="badge bg-secondary text-decoration-none text-white">Cheap</a>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-thumbs-up me-1"></i>324
                                </span>
                                <span class="badge bg-danger">
                                    <i class="fas fa-eye me-1"></i><?= htmlspecialchars($seller_views);?> views
                                </span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary w-100 d-none">VISIT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


     <div class='w-100 mt-4 text-center'>
      
         <div id='spinner'>

             <div class="spinner-border text-primary" role="status">

                 <span class="sr-only">Loading...</span>

              </div>

              <p class='text-muted mt-2'>Loading map...</p>

         </div>

     </div>


     <iframe
          src="https://www.google.com/maps?q=<?php echo urlencode($user_address); ?>&output=embed"
          class="w-100 h-auto"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          onload="hideSpinner()">
      </iframe>


     </div>

    </div>

<!--   product-lists -->


    <div class="container py-4">
        <div class="row">
            <!-- Categories Sidebar -->
            <div class="col-md-3">
                <h5 class="mb-3">Categories</h5>
                <div class="categories-list">
                    <?php 
                    require("engine/config.php");
                    $getsearch=$conn->prepare("SELECT COUNT(*) AS count, product_category FROM products GROUP BY product_category"); 
                    if($getsearch->execute()){
                        $result = $getsearch->get_result();
                        while($row = $result->fetch_assoc()){ ?>
                            <a href="products.php?search=<?= htmlspecialchars($row['product_name']); ?>" class="category-link  text-decoration-none text-capitalize"><?= htmlspecialchars($row['product_category']); ?> <span>(<?= htmlspecialchars($row['count']); ?>)</span></a>  
                   <?php
                   
                        }
                    }
                    
                    ?>
                   
                </div>
                <button class="btn btn-primary w-100 mt-3">Add</button>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Promo Banner -->
                <div class="promo-banner mb-4">
                    <div class="promo-text text-center">
                        SUPER PROMO
                        <div class="fs-4">50% OFF</div>
                    </div>
                </div>

                <h5 class="mb-4">Wholesale</h5>

                <!-- Products Grid -->
                <div class="row g-4">

                <?php 

                   // Prepare the statement to select products where poster_id matches
                     $getposter = $conn->prepare("SELECT * FROM products WHERE poster_id = ?");

                     // Bind the poster_id parameter (assuming $poster_id is already set somewhere)
                     $poster = $getposter->bind_param('i', $user_id);

                     // Check if the binding was successful
                     if(!$poster) {
                             echo "Error in getting poster"; 
                             header("Location:product-details.php?id=". base64_encode($id));
                     } else {
                           // Execute the query
                            $getposter->execute();
                            // Get the result from the query
                             $products = $getposter->get_result();

                             // Loop through all products
                              while($product = $products->fetch_assoc()) {
                             // Include your user-content file for each product
                              include("contents/product-contents.php"); ?>

                    <!-- Product Card 1 -->
                    <div class="col-md-3">
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($product_image) ?>" alt="Hands Up Bottle" class="img-fluid">
                            <div class="p-3">
                                <h6><?php echo htmlspecialchars($product_name); ?> - Bottle</h6>
                                <div class="text-warning mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="text-muted mb-2">
                                                                 
                                <?php
                                    if($discountPercentage > 0):
                                         echo htmlspecialchars($discountedPrice);
                                    else:
                                         echo htmlspecialchars($originalPrice);
                                     endif;
                                
                                ?>
                                        
                                /per crate</div>
                                <div class="quantity-control mb-2">
                             
                                </div>
                                <a href='product-details.php?id=<?php echo htmlspecialchars(base64_encode($product_id));?>' class="btn btn-primary w-100">Buy</a>
                            </div>
                        </div>
                    </div>
                  
                 <?php            }
                          }

                     ?>

                    <!-- Additional product cards... -->
                </div>
            </div>
        </div>
    </div>

   <!-- photo gallery part -->

    <div class="container py-4">
        <!-- Photo Gallery Section -->
        <section class="mb-5">
            <h4 class="mb-3 fw-bold">Photo gallery</h4>
            <div class="row g-3 mt-2">
            <?php 

// Prepare the statement to select images where sid matches
$getmore = $conn->prepare("SELECT * FROM picx WHERE sid = ?");

if ($getmore) {
    // Bind the parameter (assuming $user_id is an integer)
    $getmore->bind_param('i', $user_id);

    // Execute the query
    if ($getmore->execute()) {
        // Get the result set
        $moreproducts = $getmore->get_result();

        // Loop through each row
        while ($product = $moreproducts->fetch_assoc()) {
            // Check if 'pictures' column exists and is not empty
            if (!empty($product['pictures'])) {
                // Assuming 'pictures' column stores comma-separated image URLs
                $more_pictures = explode(",", $product['pictures']);

                foreach ($more_pictures as $picture) {
                    ?>
                    <div class="col-md-3">
                        <img src="<?php echo htmlspecialchars(trim($picture)); ?>" alt="Store display" class="gallery-img">
                    </div>
                    <?php
                }
            }
        }
    } else {
        echo "Error executing query.";
    }

    // Close the statement
    $getmore->close();
} else {
    echo "Error preparing statement.";
    header("Location: product-details.php?id=" . base64_encode($id));
    exit;
}
?>            
            </div>
        </section>

        <!-- Other Choices Section -->
        <section>
            <h4 class="mb-4">Other choices for import</h4>
            <div class="row g-4">
                <!-- Business Card 1 -->
                   <?php 
    $stmt = $conn->prepare("SELECT * FROM user_profile WHERE user_type = 'importer' AND verified = 1");
    if(!$stmt){
        echo "<span class='text-muted mt-4 px-2'>No user profile found</span>";
    }
    else{
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            while($row = $result->fetch_assoc()){
?>
                <a href="store.php?id=<?php echo htmlspecialchars($row['id']);?>" class="business-link">
                    <div class="col-md-3">
                        <div class="business-card position-relative">
                            <img src="<?php echo htmlspecialchars($row['user_image']); ?>" alt="Jay's and Josh" class="business-img">
                            <button class="share-btn">
                                <i class="fas fa-share-alt"></i>
                            </button>
                            <div class="p-3">
                                <h5 class="mb-2"><?php echo htmlspecialchars($row['user_name']); ?></h5>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-location-dot me-1"></i>
                                    <?= htmlspecialchars($row['user_address']); ?>
                                </p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="rating-badge">4.34</span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-primary">
                                        <i class="fas fa-thumbs-up me-1"></i>324
                                    </span>
                                    <span class="badge bg-danger ms-1">
                                        <i class="fas fa-heart me-1"></i>193
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
<?php  
            }
        } else {
            echo "No user found";
        }
        $stmt->close();
    }
?>

                <!-- Additional cards... -->
            </div>
        </section>
    </div>
    
    <?php include ("components/banner-signup.php"); ?>
    <br><br>
    <div class="container mt-5">
        <h3 class="text-center fw-bold mb-4">THIS PLACES RECEIVED THE BEST REVIEWS THIS WEEK</h3>
        <div class="row">
            <!-- Review Cards -->
            <?php 
                  
                  $stmt_reviews = $conn->prepare("SELECT * FROM user_profile WHERE verified = 1 AND  user_type = 'importer'");
                  if(!$stmt_reviews){
                      echo "<span class='text-muted mt-4 px-2'>No user profile found</span>";
                  }
                  else{
                      $stmt_reviews->execute();
                      $result = $stmt_reviews->get_result();
                      if($result){
                      while($row = $result->fetch_assoc()){?>
                           <a href="store.php?id=<?php echo htmlspecialchars($row['id']);?>" class="business-link">

            <div class="col-md-4">
                <div class="card review-card">
                    <div class="badge-container">
                        <span class="badge bg-primary"> <i class="fas fa-thumbs-up"></i> 324</span>
                        <span class="badge bg-danger"> <i class="fas fa-heart"></i> 123</span>
                    </div>
                    <a href='store.php?id=<?= htmlspecialchars($row['id']);?>'><img src="<?php echo htmlspecialchars($row['user_image']) ?>" alt="Store Image"></a>
                    <div class="card-body">
                        <button class="btn btn-light share-btn"> <i class="fas fa-share"></i> </button>
                        <h5 class="card-title"><?= htmlspecialchars($row['user_name']); ?></h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i><?= htmlspecialchars($row['user_address']) ?></p>
                        <div class="d-flex align-items-center">
                            <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#189;</span>
                            <span class="ms-2">4.34</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } }  } ?>    
         
          
        </div>
    </div>

    <br><br><br><br>
    
    
    <?php include ("components/footer.php");?>
  
    <script>
         $('.numbering').load('engine/item-numbering.php');
          function hideSpinner(){
            //  document.getElementById('spinner').style.display = 'none';
            $(".spinner-border").hide();
         }


    </script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
</body>
</html>