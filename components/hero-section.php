  
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-header">
                    <i class="fas fa-bars me-2"></i> ALL CATEGORIES
                </div>
                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-car"></i> Car
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-truck"></i> Trunk
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-bicycle"></i> Bike
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-seedling"></i> Plant
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-building"></i> Apartments
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-mobile-alt"></i> Electronic
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-tshirt"></i> Clothes
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                            <div>
                                <i class="fas fa-paint-brush"></i> Cosmetics
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </li>
                    
                </ul>
                <div class="see-more">
                    SEE MORE <i class="fas fa-arrow-right"></i>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <!-- Sort and Search -->
                <div class="search-container d-flex">
                    <div class="me-auto d-flex align-items-center">
                        <span class="me-2">Sort by:</span>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button">
                                Latest
                            </button>
                        </div>
                    </div>
                    <div class="search-box">       
                        <input type="text" name="search" id='search' class="form-control" placeholder="Search">
                        <button name='submit' id='submit' class="search-btn">
                            <i class="fas fa-search text-white"></i>
                        </button>                    
                    </div>
                </div>
                
                <!-- Hero Section with Modern Interior -->
                <div class="hero-section">
                    <div class="hero-text">
                        <h1 class="hero-heading">WE GOT YOU<br>COVERED</h1>
                        <p class="hero-subtext">Looking for where to rent your<br>equipment's, cars, etc.<br>look no further.</p>
                        <button class="cta-button">Check Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
         $(document).on("click","#submit",function(e){
            e.preventDefault();
         let search = $("#search").val();
         if(search.length > 0){
             window.location.href = "products.php?search="+search;
         }
     });
    </script>

