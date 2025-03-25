<?php session_start();
error_reporting(E_ALL);            // Report all PHP errors
ini_set('display_errors', 1);      // Display errors in the browser


     require("../engine/config.php");
     if(isset($_SESSION['user_id'])){
         $userId = $_SESSION['user_id'];
        
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
    <title>Vendor Dashboard</title>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-dashboard.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-orange fw-bold" href="#">Eparts</a>
            <div class="position-relative d-flex align-items-center">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Search">
            </div>
            <div class="d-flex align-items-center gap-3">
            <a href='notifications.php'><i class="fas fa-bell text-secondary"></i></a>
                <img src="<?php echo"../" .htmlspecialchars($user_image); ?>" class="rounded-circle" width="32" height="32">
                <span><?php echo htmlspecialchars($user_name); ?></span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </nav>
<?php include ("components/side-bar.php"); ?>

    <!-- Main Content -->
    <div class="main-content pt-5">
        <div class="container-fluid pt-4">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
              
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">No. of Products</p>
                                <h3 class="mb-2">
                                    
                                    <?php 
                                       $getproduct = $conn->prepare("SELECT * FROM products WHERE poster_id = ? ");
                                       $getproduct->bind_param("i",$_SESSION['user_id']);
                                       $getproduct->execute();
                                       $product =  $getproduct->get_result();
                                       echo$product->num_rows;

    
                                      ?>
                                      </h3>
                                <small class="text-danger">-3.22 Form last month</small>
                            </div>
                            <i class="fas fa-building fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <?php 
                                  $getcustomers = $conn->prepare("SELECT DISTINCT buyer FROM cart WHERE payment_status = 1 AND seller_id = ?");
                                  $getcustomers->bind_param('i',$_SESSION['user_id']);
                                  $getcustomers->execute();
                                  $customers = $getcustomers->get_result();
                                  $numCustomers = $customers->num_rows;
                                ?>
                                <p class="text-secondary mb-1">Customers</p>
                                <h3 class="mb-2"><?php  if($numCustomers>0): echo$numCustomers; else: echo "0"; endif; ?></h3>
                                <small class="text-danger">-2.33% Form last month</small>
                            </div>
                            <i class="fas fa-user-friends fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Revenue</p>
                                <h3 class="mb-2">0</h3>
                                <small class="text-success">+4.25% Form last month</small>
                            </div>
                            <i class="fas fa-dollar-sign fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="chart-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Income Analytics</h5>
                                <i class="fas fa-info-circle ms-2 text-secondary"></i>
                            </div>
                            <div class="dropdown">
                        
                            </div>
                        </div>
                        <canvas id="incomeChart" height="200"></canvas>
                    </div>
                    
    <script>
      
      const monthlyIncomeData = [
          1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 5500, 6000, 6500, 7000
      ];  // Example: Income for each month (January to December)
      
      const months = [
          'January', 'February', 'March', 'April', 'May', 'June', 
          'July', 'August', 'September', 'October', 'November', 'December'
      ];

      // Get the canvas element
      const ctx = document.getElementById('incomeChart').getContext('2d');

      // Create the bar chart
      const incomeChart = new Chart(ctx, {
          type: 'bar',  // Bar chart type
          data: {
              labels: months,  // x-axis labels (Months)
              datasets: [{
                  label: 'Income (Naira)',  // Label for the dataset
                  data: monthlyIncomeData,  // Monthly income data
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Bar color
                  borderColor: 'rgba(75, 192, 192, 1)',  // Bar border color
                  borderWidth: 1  // Border width
              }]
          },
          options: {
              responsive: true,
              scales: {
                  y: {
                      beginAtZero: true,  // Start y-axis from zero
                      ticks: {
                          stepSize: 500,  // Set y-axis tick step
                          callback: function(value) {
                              return '$' + value;  // Add currency symbol to y-axis
                          }
                      }
                  }
              },
              plugins: {
                  legend: {
                      position: 'top',  // Legend position
                  },
                  tooltip: {
                      callbacks: {
                          label: function(tooltipItem) {
                              return '$' + tooltipItem.raw;  // Format tooltip with currency symbol
                          }
                      }
                  }
              }
          }
      });
  </script>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Overview</h5>
                            <i class="fas fa-ellipsis-v text-secondary"></i>
                        </div>
                        <h2 class="mb-4"></h2>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Views</span>
                                <span>
                                    <?php 

                                    $getviews = $conn->prepare("SELECT SUM(product_views) AS views FROM products WHERE poster_id = ?");
                                    $getviews->bind_param("i",$_SESSION['user_id']);
                                    $getviews->execute();
                                    $views = $getviews->get_result();
                                    $result_views = $views->fetch_assoc();
                                    echo $result_views['views'];
                                    $est_views = ($result_views['views']/100);

                                         
                            
                                 ?></span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width:<?= htmlspecialchars($est_views)?>%"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Comments</span>
                                <span>
                                <?php
                                     $getcomments = $conn->prepare("
                                      SELECT COUNT(*) AS count 
                                      FROM seller_comment
                                      INNER JOIN products ON seller_comment.product_name = products.product_name
                                      INNER JOIN user_profile ON products.poster_id = user_profile.id
                                      WHERE products.poster_id = ?
                                     ");
                                   $getcomments->bind_param("i", $_SESSION['user_id']);
                                   if ($getcomments->execute()) {
                                      $comments = $getcomments->get_result();
                                      $result_comments = $comments->fetch_assoc();
                                      echo$result_comments['count'];
                                      $est_comments =  round($result_comments['count']/100);

                                    } 
                                 ?>

                                </span>
                            </div> 
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width:<?= htmlspecialchars($est_comments) ?>%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Rating</span>
                                <span>0</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-4">
        <div class="transaction-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0">Recent Transaction History</h5>
                    <i class="fas fa-info-circle text-muted"></i>
                </div>
                <div class="dropdown">
                     <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                     This Month
                     </button>
                 <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="month">This Month</a></li>
                     <li><a class="dropdown-item" href="week">This Week</a></li>
                     <li><a class="dropdown-item" href="today">Today</a></li>
                 </ul>
                 </div>

            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="table-header">
                            <th>Orders <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Date <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Items category <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Item Name <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Status <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th>Price <i class="fas fa-arrow-up-wide-short sort-icon"></i></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
// Initialize the monthly_income array before the loop
$monthly_income = [];

$getmycustomers = $conn->prepare("SELECT 
                                    cart.buyer, 
                                    cart.itemId,
                                    cart.seller_id,
                                    cart.payment_status,
                                    products.product_id,
                                    products.product_name, 
                                    products.product_category, 
                                    products.product_price AS product_price, 
                                    buyer_receipt.reference_no AS reference_no,
                                    buyer_receipt.date_added AS date_added,
                                    user_profile.user_name AS user_name,
                                    user_profile.id 
                                  FROM 
                                    cart 
                                  INNER JOIN user_profile ON cart.buyer = user_profile.id 
                                  INNER JOIN products ON cart.itemId = products.product_id 
                                  INNER JOIN buyer_receipt ON cart.buyer = buyer_receipt.client_id
                                  WHERE 
                                    cart.payment_status = 1 AND cart.seller_id = ?");
$getmycustomers->bind_param("i", $_SESSION['user_id']);
$getmycustomers->execute();
$thecustomers = $getmycustomers->get_result();

while ($mycustomer = $thecustomers->fetch_assoc()):
    // Calculate the month based on the date_added field from the database
    $month = date("Y-m", strtotime($mycustomer['date_added']));
    
    // Ensure that the month is initialized in the array if it doesn't exist
    if (!isset($monthly_income[$month])) {
        $monthly_income[$month] = 0;
    }

    // Add the product price to the monthly income for that month
    $monthly_income[$month] += $mycustomer['product_price'];
?>

<tr>
    <td>
        <div class="d-flex align-items-center gap-2">
            <img src="" class="avatar" alt="<?= htmlspecialchars($mycustomer['user_name']) ?>">
            <div>
                <div><?= htmlspecialchars($mycustomer['user_name']) ?></div>
                <div class="order-id">#<?= htmlspecialchars($mycustomer['reference_no']) ?></div>
            </div>
        </div>
    </td>
    <td><?= htmlspecialchars($mycustomer['date_added']) ?></td>
    <td><?= htmlspecialchars($mycustomer['product_category']) ?></td>
    <td><?= htmlspecialchars($mycustomer['product_name']) ?></td>
    <td><span class="status-paid">Paid</span></td>
    <td><?= htmlspecialchars($mycustomer['product_price']) ?></td>
    <td><i class="fas fa-ellipsis-vertical text-muted"></i></td>
</tr>

<?php
endwhile;
?>

                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>

</body>
</html>