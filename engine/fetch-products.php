<?php

require("config.php");

$query = "SELECT * FROM products WHERE sold = 0 AND featured_product = 1"; 
if(isset($_POST['category']) && !empty($_POST['category'])){
     $category = $_POST['category'];
     $query .= " AND product_name like '%".$category."%' OR product_category like '%".$category."%'";
}
$query .= " ORDER BY featured_product DESC, date_added DESC LIMIT 8";
$stmt = $conn->prepare($query);
 if($stmt->execute()){
     $result = $stmt->get_result();  
     while ($product = $result->fetch_assoc())  {

             include("../contents/product-contents.php");
             $stmt_poster = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
             $stmt_poster->bind_param("i", $poster_id);
             $stmt_poster->execute();
             $result_x = $stmt_poster->get_result();
             $seller = $result_x->fetch_assoc();
             include("../contents/seller-contents.php");
                 
             ?>

         <div class="product-card">
             <a class='text-decoration-none text-dark text-capitalize' href="product-details.php?id=<?=htmlspecialchars($product_id) ?>"><img src="<?=htmlspecialchars($product_image)?>" alt="<?= htmlspecialchars($product_name);?>" class="product-image"></a>
             <div class="product-info">
                  <div class="product-title"><a class='text-decoration-none text-dark text-capitalize' href="product-details.php?id=<?=htmlspecialchars($product_id) ?>"><?= htmlspecialchars($product_name)?></a></div>
                      <div class="price"><i class='fas fa-naira-sign'></i><?= htmlspecialchars(number_format($product_price,0,2))?></div>
                      <div class="stars">★★★★★</div>
                      <div class="meta-info">
                         <span class='text-capitalize'><i class="bi bi-person"></i> By <?= htmlspecialchars($seller_details_name)?></span>
                         <span><i class="bi bi-calendar"></i><?=htmlspecialchars($product_date)?></span>
                         
                 </div>
             </div>
         </div>
<?php 

     }
}

?>