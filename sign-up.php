<!DOCTYPE html>
<html lang="en">
<head>

    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/sign-up.css">
     <?php include ("components/links.php"); ?>

</head>
<body>
<div class="container text-center mt-4">
        <h1 class="fw-bold text-dark">Sign up</h1>
    </div>
    <div class="signup-container">
        <h4 class="mb-3">Create an Account</h4>
        <form id="signupForm">
            <div class="mb-3">
                <input name='user_name' type="text" class="form-control" placeholder="Your name">
            </div>
            <div class="mb-3">
                <input name='user_email' type="email" class="form-control" placeholder="yourname@domain.com">
            </div>
            <div class="mb-3">
                <input name='user_password' type="password" class="form-control" placeholder="Password">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Re-type password">
            </div>
            <div class="mb-3">
                <label class="form-label">Are you joining as:</label>
                <div class="d-flex flex-wrap justify-content-center g-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id='Customer'>Customer</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id='Vendor'>Vendor</button>
                    
                    <input type="hidden" id="user_type" name="user_type">
                </div>
            </div>
            <div class="terms mb-3"> 
                <p>By clicking Sign up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
                <p>Already have an account? <a href="sign-in.php">Log in</a></p>
            </div>
            <button type="submit" class="btn btn-custom w-100 py-2 "><span class='spinner-border text-warning'></span> <span class='signup-note'>Sign up</span></button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
     <script src='assets/js/sign-up-process.js'></script>

</body>
</html>
