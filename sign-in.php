<?php 
$details = isset($_GET['details']) && !empty($_GET['details']) ? filter_var($_GET['details'],FILTER_SANITIZE_URL): null;
?>
<input type="hidden" name='url' id='url' value = "<?= htmlspecialchars($details) ?>">

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("components/links.php"); ?>
    <title>Sign In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/sign-in.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-light">

     <div class="card">
             
        <h2>Sign In</h2>
        <form id="signinForm" style='font-family:poppins;'>

            <div class="mb-3">
                 <label class="form-label text-secondary">Email</label>
                 <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                 <label class="form-label text-secondary">Password</label>
                 <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class='d-flex justify-content-between'>
                 <a href="sign-up.php" class='text-sm text-decoration-none mt-2'>Create Account</a>
                 <a href="forgot-password.php" class="forgot-password hover:text-decoration-none">Forgot password?</a>
            </div>

            <button type="submit" class="btn  btn-custom w-100 mt-3"> <span class='spinner-border text-warning'></span> <span class='signin-note'>Sign In</span> </button>

            <div class="container d-flex justify-content-between mt-5">
                 <a href="index.php" class="btn btn-outline-secondary me-2">Back to Home</a>
                 <a href="#" onclick="window.history.back();" class="btn btn-outline-primary">Go Back</a>
            </div>
            
            <div id="error-message" class="error-message"></div>
        </form>
    </div>

   <script src='assets/js/sign-in-process.js'></script>

</body>
</html>
