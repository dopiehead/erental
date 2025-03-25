
    <div class="container category-container">
        <h2 class="category-title">RENTALS</h2>
        
        <div class="row">
           
        <?php 
          error_reporting(E_ALL); // Report all PHP errors
          ini_set('display_errors', 1);
          include("engine/config.php");
          $getcategories = $conn->prepare("SELECT * FROM products WHERE sold = 0");
          if($getcategories->execute()){
             $result = $getcategories->get_result();
             while($product = $result->fetch_assoc()) { 
                include ("contents/product-contents.php"); ?>
                     <div class="col-6 col-md-4 col-lg-2">
                           <div class="category-card">
                                 <img src="<?= htmlspecialchars($product_image) ?>" alt="<?= htmlspecialchars($product_name) ?>">
                                 <div class="category-name text-capitalize"><?= htmlspecialchars(preg_replace("/_/"," ",$product_category)) ?></div>
                                 <div class="item-count">12 items</div>
                          </div>
                      </div>

         <?php 

            }
          }
        
        ?>

        </div>
    </div>
