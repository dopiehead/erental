
$(document).ready(function() {
    $(".spinner-border").hide();
    
    $("#signinForm").submit(function(event) {
        event.preventDefault();
        $(".spinner-border").show();
        $(".signin-note").hide();
        $('.btn-custom').prop('disabled', true);
        
        let email = $("#email").val();
        let password = $("#password").val();
        let url = $("#url").val().trim(); // Trim URL to ensure it's not empty
        
        $.ajax({
            type: "POST",
            url: "../engine/signin-process.php",
            data: { email: email, password: password },
            dataType: "json",
            success: function(response) {
                $(".spinner-border").hide();
                $(".signin-note").show();
                $('.btn-custom').prop('disabled', false);
                
                if (response.status === "success") {
                    if (url && url !== "") {
                        window.location.href = url;
                    } else {
                        switch (response.user_role) {
                            case "Vendor":
                                window.location.href = "dashboard/vendor-dashboard.php";
                                break;
                            
                                case "Admin":
                                window.location.href = "dashboard/admin-dashboard.php";
                                break;

                            default:
                                window.location.href = "dashboard/user-dashboard.php";
                                break;
                        }
                    }
                } else {
                    $("#error-message").text(response.message);
                }
            },
            error: function() {
                $(".spinner-border").hide();
                $(".signin-note").show();
                $('.btn-custom').prop('disabled', false);
                $("#error-message").text("Something went wrong. Please try again.");
            }
        });
    });
});

