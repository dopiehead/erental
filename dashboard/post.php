<?php 
session_start();

require("../engine/config.php"); 
error_reporting(E_ALL);        // Report all errors
ini_set('display_errors', 1);
$getkey = $conn->prepare("SELECT * FROM information");
$getkey->execute();
$result = $getkey->get_result();
$key_variable = $result->fetch_assoc();
if ($key_variable) {
    $key = $key_variable['mykey'];
} else {
    echo "Error: Could not retrieve the key from the database.";
    exit;
}
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) { 
    if ($_SESSION['user_role'] == 'Customer') {
        header("Location:profile.php");
        exit();
    } else {
      $userId = $_SESSION['user_id']; 
        include("contents/profile-contents.php");
    }
} else { 
   header("Location: ../../index.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
     <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
     <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-dashboard.css">
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-posts.css">

</head>
<body class="bg-light">
<?php include ("components/navigator.php"); ?>
    <!-- Navbar -->
      <?php include ("components/side-bar.php"); ?>

    <!-- Main Content -->
          <div class="main-content pt-2 my-3 px-2">
              <h6 class='fw-bold mt-5'>Upload product</h6>              
              <div class="container">

<div class="row"> 

     <div class="col-md-6">
         <br>    
         <p><input type="checkbox" onclick="discount()" name="Discount">  Discount sales</p>
         <p><input type="checkbox" onclick="foreign()" name="foreign"> Foreign products</p>
         <?php if (date('N') == 7) { ?>
             <p><input type="checkbox" id="toggleButton"> Used products</p>
         <?php } ?>
     </div>

  <div class="col-md-6">
    
     <?php
    
          $vendor = mysqli_query($conn,"select * from user_profile where id = '$user_id' AND user_type !='Customer'");

          if ($vendor) {
     
             while ($dataVendor = mysqli_fetch_array($vendor)) {

                  $vendorName = $dataVendor['user_name'];

                  $vendorImg = $dataVendor['user_image'];

             }

         }

     ?>
    
  </div>

</div>

<div id="popup" class="popup active bg-white px-3 py-3 shadow-lg rounded">
    <a class="close btn btn-link text-dark position-absolute" style="right: 10px; top: 5px;" onclick="verify_id()">×</a>

    <form method="post" id="formPopup" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <h4 class="fw-bold mb-2">Upload Passport/Selfie</h4>
                    <p class="text-muted small">Please upload a passport-size photograph or selfie (max: 2MB). This helps reduce spam and phishing. Required for all sellers.</p>
                    <input type="hidden" name="sid" value="<?php echo $_SESSION['user_id']?>">
                    <input type="hidden" name="verified" value="0">
                    <input type="file" name="img" accept="image/*" capture="environment" class="form-control form-control-sm">
                </div>

                <div class="col-12 col-md-6">
                    <h4 class="fw-bold mb-2">Upload Valid ID</h4>
                    <p class="text-muted small">Upload any valid ID card (max: 2MB). Verification takes 6-24 hours for new seller accounts.</p>
                    <input type="file" name="valid_id" accept="image/*" class="form-control form-control-sm">
                </div>

                <div class="col-12 text-center" style="display: none;" id="loading-image">
                    <img id="loader" height="50" width="80" src="loading-image.GIF" alt="Loading...">
                </div>

                <div class="col-12">
                    <button type="submit" name="submit_verify" class="btn btn-success w-100 py-2">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<br>

<h6>Product details</h6>

<div class="row">
  
<div class="col-md-6">

<form id="form-product">

 <input type="text" class="form-control" name="product_name" placeholder="....Write product Name">

</div>

  
<div class="col-md-2">

<select name="product_category" id="product_category" style="text-transform: capitalize;" class="form-control">

<option>Choose Category</option>

<?php

$query_category = mysqli_query($conn,"SELECT product_category FROM products");

while ($row = mysqli_fetch_array($query_category)) {
   
?>
<option value="<?php echo$row['product_category']?>"><?php echo$row['product_category']?></option>

<?php

}

?>
</select>


</div>

<div class="col-md-2">

<?php include ("contents/select-colors.php"); ?>

</div>

<div class='col-md-2'>
    
     <input style="font-size:14px; " type='number' name='quantity' min='0' id='quantity' class='form-control' placeholder='Quantity'>   
      
</div>

</div>


<br>
<h6>Address details</h6>

<div class="row">

<div class="col-md-6">
  <select name="product_location"  style="font-size: 14px;text-transform: capitalize;"class="form-control">
         
  <?php include("contents/select-states.php"); ?>
        
</select><br></div>

<div class="col-md-6">

     <input class="form-control" type="text" name="product_address" placeholder="Street / Estate / Neighbourhood"></div>

</div>

<br>
<h6>Price details</h6>

<div class="row">


     <div class="col-md-3">
    
         <input style="font-size:14px" class="form-control" type="number" min="1" minlength="4" name="product_price" id="product_price" placeholder="Price">
   
    </div>

  <div class="col-md-3">
    
      <select name="price_denomination"  class="border border-1 border-mute form-control">

          <option value="">Denomination</option>
          <option value="200">200</option>
          <option value="500">500</option>
          <option value="1000">1000</option>
    
     </select> 
    
  </div>

  <div class="col-md-3">


  </div>

  <div class="col-md-3">

     <select style="padding:8px;border-radius:3px;" id="discount_hide" class="active border border-1 border-muted" name="discount">

         <option value="">How many percentage</option>
         <option value="10">10</option>
         <option value="20">20</option>
         <option value="30">30</option>
         <option value="40">40</option>
         <option value="50">50</option>
         <option value="60">60</option>
         <option value="70">70</option>
         <option value="80">80</option>
         <option value="90">90</option>

     </select>

 </div>


</div>
<br>

<h6>Phone number</h6>

 <div>
    
     <input style="font-size:14px;" class="form-control" type="number" min="1" minlength="4" name="phone_number" id="phone_number" value="<?php echo$user_contact ?>" placeholder="Phone number">

 </div>

<br>


<div class='mt-3'>
      <h6>Description</h6>
      <textarea style="font-size: 14px;" name="product_details"  rows="5" class="form-control" wrap="physical" placeholder="Describe your product"></textarea><br>
</div>

</div>

<br>
<span class="active" id="discount_hide"><b>How long will the discount last</b><input type="text" name="discount_time"></span>

<br>

<label class="form-control"  style="text-align: center;background-color: rgba(192,192,192,0.8);width: 100%;padding:18px;"><small  id="file-label"  style="font-size: 14px;padding: 1px;background-color: rgba(0,0,0,0.6);color: white;">Upload image (Max 4MB)</small><br></span><span id="fileName"></span><input style="display: none;" type="file" class="form-control" name="imager" accept='image/*'  onchange="updateFileName(this)"></label><br>
<input type="hidden" name="poster_type" value="vendor">
<input type="hidden" name="user_id" value="<?php echo$_SESSION['user_id']?>">
<input type="hidden" name="sold" value="0">
<input type="hidden" name="gift_picks" value="0">
<input type="hidden" name="deals" value="0">
<input type="hidden" name="views" value="0">
<input type="hidden" name="likes" value="0">
<input type="hidden" name="featured" value="0">

</div>
</div>
<?php $txn_ref = time(); $fee ="1000"; ?>

<div id="bom">
    <div id="cy">
         <div class="container text-center">
       
            <?php 
                $getverification = mysqli_query($conn,"select * from verify_seller where sid ='".htmlspecialchars($_SESSION['user_id'])."' and verified = 1 ");
                if ($getverification->num_rows==0) {?> 
                    <a type="submit" name="verify_id" onclick="verify_id()" class="btn btn-success"> Submit </a>
             <?php }else{?>

             <?php 
                $getstatus = mysqli_query($conn,"select * from user_profile");
                if($getstatus){while ($status = mysqli_fetch_array($getstatus)){
                $statusPay = $status['status'];  

                   if($statusPay==0){  ?>
                     <input type="submit" name="submit" value="Submit" class="btn btn-success">
                      <?php } else{ ?> <a onclick='paywithPaystack()' class='btn btn-success'>Pay to proceed (<i class="fa-solid fa-naira-sign"></i>1000)</a> <?php  } }  } }?>
                   
             </div>

     </div>
</div>

</form>
</div>
          </div>
    </div>
    <script src="https://js.paystack.co/v2/inline.js"></script>
    <script src='../assets/js/post.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    </body>
    </html>