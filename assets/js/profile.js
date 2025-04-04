
$(document).ready(function(){
$(".spinner-border").hide(); // Hide spinner initially
$("#verification_form").on("submit", function(e){ 
    
    e.preventDefault(); // Prevent default form submission

    $(".spinner-border").show();  // Show spinner
    $(".submit_note").hide();  // Hide note
    $(".proof_of_identity_button").prop("disabled", true); // Disable button
   
    let formData = new FormData(this); // Get form data
    
    $.ajax({
         type: "POST",
         url: "../engine/facial_recognition.php",
         data: formData,
         processData: false, // Prevent jQuery from processing data
         contentType: false, // Prevent jQuery from setting content type
         success: function(response){
            $(".spinner-border").hide(); // Hide spinner
            $(".submit_note").show(); // Show note
            $(".proof_of_identity_button").prop("disabled", false); // Re-enable button

            if(response.trim() === "success") {
                swal({
                    title: "Success",
                    text: "Verification successful!",
                    icon: "success",
                });
            } else {
                swal({
                    title: "Verification failed",
                    icon: "warning",
                    text: response
                });
            }
        },
        error: function(err){
            $(".spinner-border").hide();
            $(".proof_of_identity_button").prop("disabled", false);
            console.log("AJAX error:", err);
        }
    });
});    $('#editpage-form').on('submit',function(e){
     if (confirm("Are you sure to change this?")) {
          e.preventDefault();
          $(".loading-image").show();
         var formdata = new FormData();
          $.ajax({
              type: "POST",
               url: "../../engine/changeprofilepic.php",
               data:new FormData(this),  
               cache:false,
               processData:false,
               contentType:false,
               success: function(response) {
               $(".loading-image").hide();
               if(response==1){
                  swal({
                      text:"Image has been changed",
                      icon:"success",
                  });
                     $('#bom').load(location.href + " #my");
                }
else
 { 
  swal({
            icon:"error",
            text:response

           });
            $("#editpage-form")[0].reset();      

            }
 }
        });
 }
    });

$('#lg').html("<select  id='lga' class='lga address_details form-control'><option>Business Axis</option></select>");
$('.location').on('change',function() {
     var location = $(this).val();
      $.ajax({

            type:"POST",
            url:"../engine/get-lga.php",
            data:{'location':location},
            success:function(data) {
                 $('#lg').html(data);
              
            }

     });

});

$('#btn-submit').on('click',function(){    
     $(".loading-image").show();
      $.ajax({

            type: "POST",
            url: "edit-page.php",
            data:  $("#editpage-details").serialize(),
            cache:false,
            contentType: "application/x-www-form-urlencoded",
             success: function(response) {            
                  if (response==1) {           
                      swal({
              
                           text:"Details update is saved",
                           icon:"success",

                        });

                   $("#editpage-details")[0].reset();          
                   $(".loading-image").hide();
                   $("#myformx").hide();

                }
            
                 else{
                      swal({

                         text:response,
                         icon:"error",

                        });
                    }

            },

             error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
    });

function cancel() {

     $("#editpage-details")[0].reset();
}
});

   
$('#cameraImage').on('change', function() {
    var fileInput = this;
    if (fileInput.files.length > 0) {
        console.log('File selected: ', fileInput.files[0].name);
    }
    uploadPic(); // No need to pass fileInput
});

function uploadPic() {
    var fileInput = $('#cameraImage')[0];
    // Check if a file is selected
    if (!fileInput.files || fileInput.files.length === 0) {
        alert('Please take a photo using your camera.');
        return false;
    }
    // Optional: Add further validation (e.g., file type or size)
    var file = fileInput.files[0];
    if (!file.type.match('image.*')) {
        alert('Only images are allowed.');
        return false;
    }
    // Proceed with file upload (if needed)
    console.log('File is valid and ready for upload.');
}


