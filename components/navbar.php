
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container navbar-border">
            <!-- Logo and Brand -->
            <a class="navbar-brand" href="index.php">
                <div style="position: relative;">
                    <svg class="house-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9.5L12 4L21 9.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 13V19.4C19 19.7314 18.7314 20 18.4 20H5.6C5.26863 20 5 19.7314 5 19.4V13" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div style="position: absolute; bottom: -7px; left: 0; right: 0; text-align: center; font-size: 10px; font-weight: bold;">RENT</div>
                </div>
                <span class="logo-text">E-Rentals</span>
            </a>
            
            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" style="color: #00CED1;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                </ul>
                
                <!-- Right Icons -->
                <div class="nav-icons ms-lg-auto">
                   
                    <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                     <?php if(isset($_SESSION['user_id'])) : ?>
                    <a href="profile.php"><i class="fas fa-user-alt"></i></a>
                    <?php else : ?>
                        <a href="sign-in.php"><i class="fas fa-user-alt"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
