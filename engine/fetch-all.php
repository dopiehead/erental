<?php
error_reporting(E_ALL);
// Display errors on the screen
ini_set('display_errors', 1);
require("config.php");
$query = "SELECT * FROM products WHERE sold = 0"; 
// Search filtering
if(isset($_POST['q']) && !empty($_POST['q'])){
     $search = explode(" ", $_POST['q']);
     foreach($search as $text){
         $query .= " AND (product_name LIKE '%".$text."%' OR product_category LIKE '%".$text."%' OR product_details LIKE '%".$text."%' OR product_condition LIKE '%".$text."%')";
    }
}

if(isset($_POST['category']) && !empty($_POST['category'])){
     $category = explode(" ",$_POST['category']);
     foreach($category as $product_category){
        $query .= " AND (product_name LIKE '%".$product_category."%' OR product_category LIKE '%".$product_category."%')";
     }
}

if(isset($_POST['condition']) && !empty($_POST['condition'])){
     $condition = $_POST['condition'];
     $query .= " AND (product_condition LIKE '%".$condition."%')";
}

if(isset($_POST['price_range']) && !empty($_POST['price_range'])){
     $price_range = (int) $_POST['price_range'];
     $query .= " AND (product_price <= '$price_range')";
}

if (isset($_POST['sort'])) {
     $sort = mysqli_real_escape_string($conn, $_POST['sort']);
     switch ($sort) {
        case 'promo':
            $query .= " AND product_discount > 0";
            break;    

        case 'featured':
            $query .= " AND featured_product = 1";
            break;
        
        case 'recent':
            $query .= " ORDER BY `featured_product` DESC, `product_id` DESC";
            break;
        
        case 'views':
            $query .= " ORDER BY `featured_product` DESC, `product_views` DESC";
            break;
        
        case 'highest':
            $query .= " ORDER BY `featured_product` DESC, CAST(`product_price` AS DECIMAL(10,2)) DESC";
            break;
        
        case 'lowest':
            $query .= " ORDER BY `featured_product` DESC, CAST(`product_price` AS DECIMAL(10,2)) ASC";
            break;
        
        default:
            $query .= " ORDER BY `featured_product` DESC, `product_id` DESC";
            break;
    }
} else {
    $query .= " ORDER BY `featured_product` DESC, `product_id` DESC";
}

 $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
 $num_per_page = 9;  // You can adjust the number of products per page as needed
 $initial_page = ($page - 1) * $num_per_page;
 $query .= " LIMIT ?, ?";
 $stmt = $conn->prepare($query);
 $stmt->bind_param("ii",$initial_page,$num_per_page);
 $stmt->execute();
 $result = $stmt->get_result(); ?>
     <div class='product-grid'>
      <?php 
        while ($product = $result->fetch_assoc()) {
             include("../contents/product-contents.php");
             $stmt_poster = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
             $stmt_poster->bind_param("i", $poster_id);
             $stmt_poster->execute();
             $result_x = $stmt_poster->get_result();
             $seller = $result_x->fetch_assoc();
             include("../contents/seller-contents.php")
?>
     <div class="product-card">
        <a class='text-decoration-none text-dark text-capitalize' href="product-details.php?id=<?=htmlspecialchars($product['product_id'])?>">
            <img style='height:200px;' class='w-100' src="<?=htmlspecialchars($product['product_image'])?>" alt="<?= htmlspecialchars($product['product_name']);?>" class="product-image">
        </a>
        <div class="product-info">
            <div class="product-title">
                <a class='text-decoration-none text-dark text-capitalize' href="product-details.php?id=<?=htmlspecialchars($product['product_id'])?>">
                    <?= htmlspecialchars($product['product_name'])?>
                </a>
            </div>
            <div class="price"><i class='fas fa-naira-sign'></i><?= htmlspecialchars(number_format($product['product_price'], 2))?></div>
            <div class="stars">               
             <?php 
                 if($product_rating==0){
                     echo "<span class='fas fa-star'></span><span class='fas fa-star'></span><span class='fas fa-star'></span><span class='fas fa-star'></span>";
                 } 
                 elseif($product_rating > 0 && $product_rating<20){
                    echo"<span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star'></span><span class='fas fa-star'></span>";
                 }
                 elseif($product_rating > 20 && $product_rating<50){
                    echo"<span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star'></span>";
                 }
                 elseif($product_rating > 50 && $product_rating<100){
                    echo"<span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span><span class='fas fa-star text-warning'></span>";
                 }
            ?>            
        </div>
            <div class="meta-info">
                <span><i class="bi bi-person"></i> By <?=  htmlspecialchars($seller_details_name) ?></span>
                <span class='text-capitalize'><i class="bi bi-calendar"></i> <?= " ". htmlspecialchars($product['date_added'])?></span>
            </div>
        </div>
     </div>

<?php 
}
?>

</div>

<?php 
$pageres = $conn->query("SELECT COUNT(*) as total FROM products WHERE sold = 0");
$numpage = $pageres->fetch_assoc()['total'];
$total_num_page = ceil($numpage / $num_per_page);
if ($total_num_page > 1) {

    echo "<div class='pagination mt-2 mb-4 text-center'>";
    
    // Previous button
            if ($page > 1) {
                   echo '<span id="page_num"><a class="btn-success prev" id="' . ($page - 1) . '">&lt;</a></span>';
             }

    // Page numbers
              for ($i = 1; $i <= $total_num_page; $i++) {
                  if ($i == $page) {
                      echo '<span id="page_num"><a class="btn-success active-button" id="' . $i . '">' . $i . '</a></span>';
                 } else {
                      echo '<span id="page_num"><a class="btn-success" id="' . $i . '">' . $i . '</a></span>';
                  }
  }

    // Next button
    if ($page < $total_num_page) {
           echo '<span id="page_num"><a class="btn-success next" id="' . ($page + 1) . '">&gt;</a></span>';
    } 
 ?>
     </div>
<?php
}
?>
