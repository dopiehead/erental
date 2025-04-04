    
   
    $(document).ready(function() {
        $(".spinner-border").hide();  // Initially hide the spinner

        // User Type Selection
        $(".btn-outline-secondary").click(function(e) {
            e.preventDefault(); // Prevent default button click
            var userType = $(this).attr("id"); // Get the id of the clicked button
            $("#user_type").val(userType); // Set the value of hidden input
            $(this).addClass("btn-secondary text-white"); // Highlight selected button
            $(this).siblings().removeClass("btn-secondary text-white"); // Remove from others
        });

        // Form Submission
        $("#signupForm").submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            $(".spinner-border").show(); // Show spinner
            $(".signup-note").hide(); // Hide any previous signup notes
            $('.btn-custom').prop('disabled', true); // Disable the submit button

            var formData = $("#signupForm").serialize(); // Get form data

            $.ajax({
                 type: "POST",
                 url: "../engine/signup-process.php", // Adjust URL as needed
                 data: formData,
                 dataType: "json",
                 success: function(response) {
                     $(".spinner-border").hide(); // Hide spinner
                     $(".signup-note").show(); // Show signup note

                     console.log(response);  // Log the entire response for debugging

                    if (response.status === "success") {
                        swal({
                            icon: "success",
                            title: "Registration Successful",
                            text: response.message
                        });

                        $("#signupForm")[0].reset(); // Reset the form
                        $('.btn-custom').prop('disabled', false); // Re-enable the submit button

                    } else {
                        swal({
                            icon: "warning",
                            title: "Registration Failed",
                            text: response.message
                        });

                        $('.btn-custom').prop('disabled', false); // Re-enable the submit button
                    }
                },
                error: function(err) {
                    $(".spinner-border").hide(); // Hide spinner if error occurs
                    console.error(err);  // Log the error for debugging
                    swal({
                        icon: "error",
                        title: "Registration Failed",
                        text: err.responseText || "Something went wrong"
                    });

                    $('.btn-custom').prop('disabled', false); // Re-enable the submit button
                    $(".signup-note").show();
                }
            });
        });
    });
