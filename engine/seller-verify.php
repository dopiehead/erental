<?php session_start();

require 'config.php';

$sid = mysqli_escape_string($conn,$_POST['sid']);
    
  $verified =  mysqli_escape_string($conn,$_POST['verified']);

  $date=date("D, F d, Y g:iA", strtotime('+1 hours'));

$maxsize=5242880;    

$imageFolder="seller-verification/";

$basename= mysqli_escape_string($conn,basename($_FILES["img"]["name"]));

$basenamex=mysqli_escape_string($conn,basename($_FILES["valid_id"]["name"]));

$imagePath=$imageFolder.$basename;

$imagePathx=$imageFolder.$basenamex;

$allowed_extensions = array("jpg",
    "jpeg",
    "png",
      "JPG",
    "JPEG",
    "PNG");

$imageExtension=pathinfo($imagePath,PATHINFO_EXTENSION);

$imageExtensionx=pathinfo($imagePathx,PATHINFO_EXTENSION);

$image_temp_name=$_FILES["img"]["tmp_name"];

$image_temp_namex=$_FILES["valid_id"]["tmp_name"];


if (!file_exists($image_temp_name) || !file_exists($image_temp_namex)) {
  
 echo "Choose Image file to upload"; 
}

elseif(!in_array($imageExtension,$allowed_extensions) && !in_array($imageExtensionx,$allowed_extensions) ){ echo "Kindly upload valid Image in png and Jpeg only";
    
}

elseif (($_FILES["img"]["size"] > $maxsize)) {
    
   "Image file size limit is exceeded"; 

}

else{

$upload=move_uploaded_file($image_temp_name,$imagePath); 

$upload=move_uploaded_file($image_temp_namex,$imagePathx); 

    $check_verify =mysqli_query($conn,"select * from verify_seller where sid = '$sid'");

    if ($check_verify->num_rows>0) {
      
echo "Your verification is being processed. We will get back to you within 24 hours.";

    }

else{

   $a="insert into verify_seller(sid,img,valid_id,verified,date)values('".htmlspecialchars($sid)."','".htmlspecialchars($imagePath)."','".htmlspecialchars($imagePathx)."','".htmlspecialchars($verified)."','".htmlspecialchars($date)."')";

 $r=mysqli_query($conn,$a);

 if ($r) {
     
 	echo "1";
 }

else{

  echo "Images upload not successful.";
}

}

}

?>