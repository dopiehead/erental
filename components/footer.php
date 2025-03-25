<footer class="bg-success text-white py-5">
    <div class="container">
        <div class="row mb-4">
            <!-- Logo Column -->
            <div class="col-12 col-md-2 mb-3">
                <h5>E-rentals</h5>
            </div>
            
            <!-- Product Column -->
            <div class="col-6 col-md-2 mb-3">
                <h6 class="text-white mb-3">Product</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Security</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Business</a></li>
                 
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Resources</a></li>
                </ul>
            </div>
            
            <!-- Explore Column -->
            <div class="col-6 col-md-2 mb-3">
                <h6 class="text-white mb-3">Explore</h6>
                <ul class="nav flex-column">
              
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">API</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Partners</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Atom</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Electron</a></li>
                
                </ul>
            </div>
            
            <!-- Support Column -->
            <div class="col-6 col-md-2 mb-3">
                <h6 class="text-white mb-3">Support</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Help</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Community</a></li>                
                 
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Status</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Contact E-parts</a></li>
                </ul>
            </div>
            
            <!-- Company Column -->
            <div class="col-6 col-md-2 mb-3">
                <h6 class="text-white mb-3">Company</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">About</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Blog</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Careers</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Shop</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Section -->
        <div class="border-top border-white-50 pt-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-white-50 small">
                    © 2025 E-parts NG. | Terms | Privacy
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-linkedin"></i></a>
                   
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    $(document).ready(function () {
        // Cache DOM elements
        const $spinner = $(".spinner-border");
        const $subscribeNote = $(".subscribe-note");
        const $emailInput = $("#newsletter-email");

        // Hide spinner initially
        $spinner.hide();

        $(document).on("click", ".newsletter-button", function (event) {
            // Show spinner and hide subscribe note
            $spinner.show();
            $subscribeNote.hide();

            event.preventDefault();

            // Get email value
            const email = $emailInput.val();

            if (email === "") {
                // Show warning if no email is provided
                swal({
                    title: "Notice",
                    icon: "warning",
                    text: "Please enter an email address"
                });
                $spinner.hide();
                $subscribeNote.show();
                return;
            }

            // AJAX request to subscribe
            $.ajax({
                url: "engine/subscribe.php",
                method: "POST",
                data: { email: email },
                success: function (response) {
                    $spinner.hide();
                    $subscribeNote.show();

                    if (response === "1") {
                        // Success message
                        swal({
                            title: "Success",
                            icon: "success",
                            text: "You have successfully subscribed to our newsletter"
                        });
                    } else {
                        // Error message
                        swal({
                            title: "Notice",
                            icon: "warning",
                            text: response
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $spinner.hide();
                    $subscribeNote.show();
                    console.log("Error: ", errorThrown);
                    swal({
                        title: "Error",
                        icon: "error",
                        text: "An error occurred. Please try again later."
                    });
                }
            });
        });
    });
</script>
