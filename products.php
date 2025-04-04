<?php session_start();
   $is_category = isset($_GET['category']) && !empty($_GET['category']) ? preg_replace("/ /", "_", strtolower(trim($_GET['category']))) : " ";
   $is_search = isset($_GET['search']) && !empty($_GET['search']) ? preg_replace("/ /", "+", strtolower(trim($_GET['search']))) : " ";
   require("engine/config.php"); 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
     <?php include("components/links.php"); ?>
    <title>Products</title>
    <link rel="stylesheet" href="assets/css/products.css">
</head>
<body>
    <?php include("components/navbar.php"); ?>
    <div class="red-header">
        <div class="container">
            <nav class="text-white">
                <a href="index.php" class="text-white text-decoration-none">Home</a> /
            </nav>
        </div>
    </div>

    <div class="container mt-4">
        <div class="search-bar">
            <div class="row align-items-center">
                <div class="col-md-2">
                     <select name="condition" class='border border-1 border-muted px-1 py-1 rounded rounded-2 btn-condition'>
                           <option value="">Choose condition</option>
                           <option value="new">New</option>
                           <option value="used">Tokunbo</option>
                     </select>
                  </div>

                <div class="col-md-8">
                    <div class="d-flex">
                        <span class="me-3">Sort by:</span>
                        <select name='sort' id='sort' class="form-select w-25">
                            <option class='recent'>Latest</option>
                            <option class='views'>Most viewed</option>
                            <option value="promo">Discount</option>
                            <option value="lowest">Lowest Price</option>
                            <option value="highest">Highest Price</option>
                            <option value="featured">Featured</option>
    
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <input name='q' id='q' type="search" class="form-control" placeholder="Search">
                </div>
            </div>
        </div>

        <?php if (!empty($is_search) || !empty($is_category)) : ?>
        <script>
    $(document).ready(function () {
        <?php if (!empty($is_search)) : ?>
        const search = "<?= htmlspecialchars($is_search) ?>";
        $("#q").val(search);
        setTimeout(() => $("#q").trigger("keyup"), 500);
        <?php endif; ?>

        <?php if (!empty($is_category)) : ?>
        const category = "<?= htmlspecialchars(preg_replace('/_/', ' ', $is_category)) ?>".toLowerCase();
        
        function clickCategory() {
            const categoryElement = $(".btn-category").filter(function () {
                return $(this).text().trim().toLowerCase() === category;
            });

            if (categoryElement.length) {
                console.log("Category found, clicking:", categoryElement.text());
                categoryElement.addClass("active-button");

                // Try `.click()` instead of `.trigger("click")`
                setTimeout(() => categoryElement[0].click(), 300); 
            } else {
                console.log("No matching category found.");
            }
        }

        setTimeout(clickCategory, 300);
        <?php endif; ?>
    });
</script>
<?php endif; ?>


        <div class="row">
            <div class="col-md-3 sidebar">
                <h5><a class='btn-category text-dark' id = "">All Categories</a></h5>
                <?php
                
                 $category =  $conn->prepare("SELECT COUNT(*) AS count, product_category FROM products GROUP BY product_category");
                 $category->execute();
                 $result = $category->get_result();
                 while ($data_category = $result->fetch_assoc()){ ?>

                    <div class="category-item">
                         <span class='text-capitalize btn-category' id='<?=htmlspecialchars($data_category['product_category']) ?>'><?=htmlspecialchars(preg_replace("/_/"," ",$data_category['product_category'])) ?></span>
                         <span class="category-count">(<?=htmlspecialchars($data_category['count']) ?>)</span>
                     </div>

                <?php
                 }  
                ?>
                
                <h5 class="mt-4">Price  <span class='text-sm price_info'></span></h5>
                <?php

                  $sql = "SELECT MIN(product_price) AS min_price, MAX(product_price) AS max_price FROM products";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
    
                      $row = $result->fetch_assoc();
                      $minPrice = $row['min_price'];
                      $maxPrice = $row['max_price'];

                  } else {
                       echo "No prices found.";
                  }

                  ?>
                <input type="range" name="price_range" class="price_range" min="<?= htmlspecialchars($minPrice)?>" value='<?= htmlspecialchars($maxPrice)?>' max="<?= htmlspecialchars($maxPrice)?>">
                <div class="mt-2 text-muted"> <i class='fas fa-naira-sign'> </i> <?=htmlspecialchars(number_format($minPrice))?> -  <i class='fas fa-naira-sign'></i><?= htmlspecialchars(number_format($maxPrice))?></div>
            </div>

            <div class="col-md-9">
                <div class="row">
                   
                 <div id ='spinner' class='d-flex justify-content-center align-items-center'>
                      
                      <span class='spinner-border text-secondary fs-3'></span>

                 </div>

                    <div class='product-container'>

                    </div>
         
                </div>
            </div>
        </div>
    </div>
    <br><br>
 <script src='assets/js/fetch.js'></script>

</body>
</html>