
    <div class="container category-container">
        <h2 class="category-title">RENTALS</h2>
        
        <div class="row">
           
        <?php 
          error_reporting(E_ALL); // Report all PHP errors
          ini_set('display_errors', 1);
          include("engine/config.php");
          $query = "SELECT 
               COUNT(*) AS count,
               categories.category_name AS product_name,
               categories.category_image AS product_image,
               products.product_category 
                FROM  categories
                JOIN  products ON categories.category_name = products.product_category
                GROUP BY products.product_category "; 
          $getcategories = $conn->prepare($query);
          if($getcategories->execute()){
             $result = $getcategories->get_result();
             while($product = $result->fetch_assoc()) { 
                include ("contents/product-contents.php"); ?>
                     <div class="col-6 col-md-4 col-lg-2">
                           <div class="category-card">
                           <a href='products.php?category=<?=htmlspecialchars($product_category) ?>'><img src="<?= htmlspecialchars($product_image) ?>" alt="<?= htmlspecialchars($product_name) ?>"></a>
                                 <div class="category-name text-capitalize"><a class='text-dark text-decoration-none' href='products.php?category=<?=htmlspecialchars($product_category) ?>'><?= htmlspecialchars(preg_replace("/_/"," & ",$product_category)) ?></a></div>
                                 <div class="item-count"><?=htmlspecialchars($product['count'])?></div>
                          </div>
                      </div>

         <?php 

            }
          }
        
        ?>

        </div>
    </div>
