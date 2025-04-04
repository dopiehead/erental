<?php session_start();
     if(isset($_SESSION['user_id'])){
         $userId = $_SESSION['user_id'];
         require("../engine/config.php");
         include("contents/profile-contents.php");        
     }
     else{
        header("Location:../index.php");
        exit();
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-dashboard.css">
    <link rel="stylesheet" href="../assets/css/flickity.min.css">
    <script src="../assets/js/sweetalert.min.js"></script> 
    <script src="../assets/js/flickity.pkgd.min.js"></script>

     <style>
        .spinner-border{
            display:none;
        }
     </style>
</head>
<body class="bg-light">
<?php include ("components/navigator.php"); 
     $currentPage = 'profile';
     include ("components/side-bar.php");     
     ?>
    <!-- Main Content -->
    <div class="main-content pt-5">   
          <div class="container-fluid p-4">
             <div id="label">
                 <div id="messages_home" style="text-align: center;">
                     <div class="tab">
                          <a class="tablinks btn btn-primary"  id="defaultOpen" onclick="openCity(event,'London')">My profile</a>
                          <a class="tablinks btn btn-trash border border-muted btn-light" onclick="openCity(event,'Paris')">Edit Profile</a>
                          <a class="tablinks btn btn-secondary" onclick="openCity(event,'Lagos')">Identity proof</a>
                     </div>
                 </div>
<br>

<div id="London" class="tabcontent">

     <table style="width: 100%;">
     <thead>
         <tr style="border-top: 2px solid rgba(192,192,192,0.4);border-bottom: 2px solid rgba(192,192,192,0.4);">
              <th style="padding:10px;" class="inbox" id="Home">Personal details</th>
         </tr>
     </thead>
     </table>

     <br><br>

 <small> <?php echo htmlspecialchars($user_name) ;?></small><br>

      <?php 
         if (isset($_SESSION['user_id']) ) {
      ?>

     <small><?=htmlspecialchars($user_phone);?></small><br>
     <small class='fw-bold'><?= htmlspecialchars($_SESSION['user_role']);?></small><br>

     <?php
     }
     ?>
     <?php if (isset($_SESSION['user_id']) ) {
     ?>

     <small> <?=htmlspecialchars($user_phone);?></small><br>
     <small>Dial code +234</small><br>

      <?php
     }
     ?>
       <small><?=htmlspecialchars($user_email);?></small>
     <br>

     <i class="fa-solid fa-user-alt"></i><br>

      <form id="editpage-form" method="post">
           <input type="hidden" name="id" value="">
           <input type="file" name="fileupload"><br><br>
           <input type="submit" name="submit" id="submit" value="Change photo (Max 4MB)" class="btn btn-success " style="color: white;"><br>
     </form>

</div>

<!-- part b  -->

<div id="Paris" class="tabcontent">

<h6>My profile</h6>

  <form id="editpage-details">

     <input type="hidden"  name="sid" value="<?php echo htmlspecialchars($user_id); ?>">

     <input type="hidden"  name="user_type" value="<?php echo htmlspecialchars($user_type); ?>">

     <input id="business_name" name="full_name" type="text" class="form-control" value="<?= htmlspecialchars($user_name); ?>" placeholder="<?php if($_SESSION['user_role']=="Customer"){echo'Full Name';}else{ echo 'Business Name';} ?>"><br>

     <div class='d-flex justify-content-center gap-3 flex-md-row flex-column'>

          <input id="password"  type="password" name="password" class='form-control' placeholder="Password">

          <input id="first_name"  type="password" name="cpassword" class='form-control' placeholder="Confirm Password">

     </div>

     <br>

     <?php if ($_SESSION['user_role'] != 'Customer') : ?>
     <input type="text" name="bank_name" style="font-size:14px;" placeholder="Bank Name" class="form-control" id="bank_name" value="" >

     <br>

     <input type="number" name="account_number" style="font-size:14px;" placeholder="Account Number" class="form-control" value=""  id="account_number">

      <br>
      <?php endif; ?>

      <h6>Contact information</h6>

      <div class='d-flex justify-content-center gap-3 flex-md-row flex-column'>

         <input type="text" name="country" placeholder="Country" id="contact" class='form-control'>

         <input type="text" name="contact" id="contact"  placeholder="Phone number" class='form-control'>

         <input type="text" name="whatsapp" id="whatsapp" placeholder="Whatsapp" value="" class='form-control'><br>

     </div>

     <br>

     <input id="business_email" type="hidden" style="font-size:14px !important" name="" class="form-control" value="<?php echo$user_email?>" placeholder="Email Address"><br>

     <h6> Address Details</h6><br>

     <?php

         require '../engine/connection.php';
         $getStates = mysqli_query($con,"SELECT * from states_in_nigeria GROUP by state");
         ?>
         <select name="location" class=" location address_details form-control mb-3" id="location">
             <option value="">Entire Nigeria</option>
             <?php
                 while ($states = mysqli_fetch_array($getStates)) {
             ?>
             <option value="<?php echo $states['state']?>"><?php echo $states['state']?></option>
             <?php }?>

         </select>

         <span id='lg' class='mt-2'></span>

         <br>
             <?php if ($_SESSION['user_role'] != 'Customer') : ?>
         <h6> About Your Organisation</h6><br>
        <textarea style="border:1px solid transparent" class="form-control" name="about" placeholder="About Your Organization" wrap="physical"></textarea><br>
         <textarea  style="border:1px solid transparent" class="form-control" name="services" placeholder="Services Your Organization Provides...." wrap="physical"></textarea><br>
         <br>
         <h6>Availability</h6><br>

         <div class='d-flex justify-content-center gap-3 flex-md-row flex-column'>

          <select name="days" class='form-control' id="time">

              <option value="">Days</option>
              <option value="monday">Monday</option>
              <option value="tuesday">Tuesday</option>
              <option value="wednesday">Wednesday</option>
              <option value="thursday">Thursday</option>
              <option value="friday">Friday</option>
              <option value="saturday">Saturday</option>
              <option value="sunday">Sunday</option>
         </select>   

     <input id="time" type="text" name="opening_time" class='form-control' placeholder="Opening Time in :am/:pm"> 

     <input id="time" type="text" name="closing_time" class='form-control' placeholder="Closing Time in :am/:pm"><br>

</div>
<?php endif; ?>
<br>

 <h6>Social Media</h6><br>

 <div class='d-flex justify-content-center flex-md-row flex-column gap-3'>
     <input id="links" type="text" name="facebook" placeholder="Facebook" class='form-control' value="">
     <input id="links" type="text" name="twitter" placeholder="Twitter" class='form-control' value="">
     <input id="links" type="text" name="linkedin" placeholder="Linkedin " class='form-control' value="">
     <input id="links" type="text" name="instagram" placeholder="Instagram" class='form-control' value="">
 </div>

 <br>

 <div style="display: none;" class="loading-image text-center" id="loading-image"><span class='spinner-border text-secondary' id="loader" height="50" width="50"></span></div>

 <div class="container  d-flex justify-content-start gap-3" style="text-align:left;font-size:0.9rem;">

     <a class="btn btn-danger" onclick="cancel()">Cancel</a>
     <a id="btn-submit" class="btn btn-success">Submit</a>

 </div>

</form>

</div>
</div>

<div id="Lagos" class="tabcontent">
     <h4 class='fw-bold'>Proof of Identity</h4>
     <br>
     <form id="verification_form" enctype="multipart/form-data" class='w-100'>
         <div class='d-flex justify-content-between align-items-center flex-md-row flex-column gap-3'>
             <input type="hidden" name="user_id" value="<?= htmlspecialchars($userId) ?>">
             <div style='border:2px dotted grey;' class='d-flex flex-column flex-row  rounded-4 px-2 py-4 bg-white'>
                 <label style='font-weight:bold' class='fw-bold mb-2 text-success' for="id_card">Upload valid ID card(max 1mb)</label>
                 <input  name="valid_id" style='font-weight:bold;'  class='mt-1 form-control border-0' type="file" accept="image/*">
             </div>  
             <br>

             <div style='border:2px dotted grey;' class='d-flex flex-column flex-row  rounded-4 px-2 py-4 bg-white'>
             <label style='font-weight:bold' class='fw-bold mb-2 text-success' for="id_card">Proof of Address(max 1mb)</label>
             <input  name="valid_id" style='font-weight:bold;'  class='mt-1 form-control border-0' type="file" accept="pdf/*">
             </div>

         </div>

         <div class='container d-flex justify-content-center'>
             <button type="submit" name='proof_of_identity_button' class='proof_of_identity_button btn border border-muted border-2 rounded bg-warning shadow text-white mt-5 cameraInput'><span class='spinner-border text-dark'></span><span class='submit_note'>Upload</span></button>
         <div>
     </form>
 </div>
</div>


<h4 class='fw-bold mt-4'>Verify image</h4>
    <div class='d-flex flex-row flex-column justify-content-center align-items-center mt-3'>
     <video id="video" autoplay></video>
     <div class='d-flex justify-content-start gap-3 mt-2'>
        <button class="btn btn-success" onclick="start_camera()"><i class='fa fa-video-camera'></i> Start camera</button>
        <button class='btn btn-primary' id="capture"><i class='fa fa-camera'></i> Capture</button>
        <button class='btn btn-danger text-white' id="" onclick="close_camera()"><i class='fa fa-stop'></i> Stop Camera</button>
    </div>

    <canvas id="canvas" style="display:none;"></canvas>
    <pre id="response"></pre>
    <span class='text-success' id="instruction"></span>
  </div>
<script>

function openCity(evt, cityName) {
var i, tabcontent, tablinks;
tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++) {
tabcontent[i].style.display = "none";
 }
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
 tablinks[i].className = tablinks[i].className.replace(" active", "");
 }
document.getElementById(cityName).style.display = "block";
evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();

 
</script>
<script src="https://api-us.faceplusplus.com/facepp/v3/detect"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script src="../assets/js/facial_recognition.js"></script>
<script src="../assets/js/profile.js"></script>

</body>
</html>