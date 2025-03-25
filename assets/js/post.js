

$("#product_color").hide(); 

$("#quantity").hide(); 

$("#product_category").on('change',function(){
   
var productInfo = $(this).val();  

if(productInfo =="building material"){
   
   $("#product_color").hide();
   $("#quantity").show();
   
}

else if(productInfo =="jobs"){$("#product_color").hide();$("#quantity").hide();}

else if(productInfo =="property"){$("#product_color").hide();$("#quantity").hide();}

else if(productInfo =="farm products"){$("#product_color").hide();$("#quantity").show();}

else if(productInfo =="service providers"){$("#product_color").hide();$("#quantity").hide();}

else{
   
  $("#product_color").show(); 
  
   $("#quantity").show();
}
   
});   
 


$('#form-product').on('submit',function(e){

       e.preventDefault();

       $(".loader").show();
      
       var formdata = new FormData();

     $.ajax({

           type: "POST",

           url: "../../engine/post-products.php",

           data:new FormData(this),

           cache:false,

           processData:false,

           contentType:false,

            success: function(response) {

            $(".loader").hide();

if (response==1) {
               swal({ 
                      title:"Success!!",
                      text:"Item(s) uploaded successfully",
                     icon:"success",

             });
               
              $('#bom').load(location.href + " #cy");
              $("#form-product")[0].reset();
              setTimeout(function() {
               window.location.href='mylistings.php'
               }, 500); 
              
             } 

     else{
         swal({
            title:"Notice",
               icon:"warning",
               text:response

 }); 
       }

           },

           error: function(jqXHR, textStatus, errorThrown) {

               console.log(errorThrown);

           }

       })

   });


function paywithPaystack() {
   var id = "<?php echo $_SESSION['user_id']; ?>";
   const paystack = new PaystackPop();
   
   // Paystack options
   var options = { 
       key: "<?php echo htmlspecialchars($key); ?>", // Replace with your Paystack public key
       email: "<?php echo $_SESSION['user_email'] ?>",
       amount: "<?php echo $fee ?>" * 100 , // Amount in kobo (multiply by 100 to convert to kobo)
       currency: "NGN",
       ref: "<?php echo $txn_ref ?>", // Unique reference generated on the server side
       metadata: {
           custom_fields: [
               {
                   display_name: "Mobile Number",
                   variable_name: "mobile_number",
                   value: document.getElementById('phone_number').value // Assuming 'phone_number' is the ID of your input field
               }
           ]
       },
       onSuccess: function(response) {
           // Handle success response
           if (response.status === "success") {
               var ref = response.reference; // Retrieve the payment reference
               window.location.href = "verify-pay.php?status=success&id="+ id+"&reference=" + ref; // Redirect to success page
           } else {
               console.log("Payment not successful");
           }
       },
       onCancel: function() {
           // Handle cancellation
           console.log("Payment canceled");
       }
   };
   
   // Initialize Paystack payment with the provided options
   paystack.newTransaction(options);
}

function updateFileName(input) {
var fileName = input.files[0].name;
 document.getElementById('file-label').innerText = fileName;
}



$('#btn-comment').on('click',function(e){
e.preventDefault();
$("#loading-image").show();
   $.ajax({
           type: "POST",
           url: "../../engine/sp-comment.php",
           data:  $("#conv").serialize(),
           success: function(response) {
           $("#loading-image").hide();
           if (response==1) {
         $('#bom').load(location.href + " #cy");
         $("#conv")[0].reset();
          swal({
           text:"Comment added successfully",
           icon:"success",
});
}
else{
swal({

   icon:"error",
 text:response
});
}         
},
          error: function(jqXHR, textStatus, errorThrown) {
           console.log(errorThrown);

           }
       });

   });


 
function installment() {
$("#installment_plan").toggleClass("active");}

function discount() {

 $("#discount_hide").toggleClass("active");}

function verify_id() {
$('#popup').toggleClass('active');
}

function used() {
$('#play').toggleClass('active');
}

$('#formPopup').on('submit',function(e){

       e.preventDefault();

       $("#loading-image").show();
       
       var formdata = new FormData();

     $.ajax({

           type: "POST",

           url: "../engine/seller-verify.php",

           data:new FormData(this),

           cache:false,

           processData:false,

           contentType:false,

            success: function(data) {

            $("#loading-image").hide();

           
if (data==1) {

       
            swal({
                      text:"Image upload successful. We will revert back shortly",
                     icon:"success",

             });
               
              $('#bom').load(location.href + " #cy");
              $("#formPopup")[0].reset();
              $("#formPopup").removeClass("active");
} 

else{
         swal({

           icon:"error",
           text:data}); 
}

           },

           error: function(jqXHR, textStatus, errorThrown) {

               console.log(errorThrown);

           }

       })

   });


 
function btn_weekly(){
$('.drop_down_weekly').toggleClass('active');
}

function btn_monthly(){
$('.drop_down_monthly').toggleClass('active');
}

function ini_pay(){
$('.initial_payment_dropdown').toggleClass('active');
}

function sub(){
$('.sub_payment_dropdown').toggleClass('active');
}

function btn_duration() {
$('.duration_form').toggleClass('active');
} 

 
$('.month').on('click',function() {
var month = $(this).attr('id');
var price = $('#product_price').val();
var math = Math.round(price/month);
$('#initial_payment').val(math);
$('#subsequent_payment').val(math);
$('#duration').val(month);
});


 
$('.week').on('click',function() {
var week = $(this).attr('id');
var price = $('#product_price').val();
var math = Math.round(price/week);
$('#initial_payment').val(math);
$('#subsequent_payment').val(math);
$('#duration').val(week);

});


function openbar() {

$(".overlay").toggle();  

}
    
   

$(document).ready(function() {
   $('#toggleButton').change(function() {
       var isChecked = $(this).prop('checked') ? 1 : 0; // Convert boolean to 1 or 0
       
       // AJAX call to update server
       $.ajax({
           type: "POST",
           url: "postads-process.php", // PHP script to handle update
           data: { status: isChecked },
           success: function(response) {
               console.log("Status updated successfully: " + response);
           },
           error: function(xhr, status, error) {
               console.error('AJAX Error: ' + status, error);
           }
       });
   });
});
