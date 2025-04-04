<?php session_start(); ?>
<html lang="en">
<head>
    <?php include("components/links.php"); ?>
    <link rel="stylesheet" href="assets/css/hero-section.css">
    <link rel="stylesheet" href="assets/css/rental-categories.css">
    <link rel="stylesheet" href="assets/css/banner.css">
    <link rel="stylesheet" href="assets/css/cities.css">
    <link rel="stylesheet" href="assets/css/blog.css">
  
    <title>Home</title>
</head>
<body>
    <?php include("components/navbar.php"); ?>
    <?php include ("components/hero-section.php"); ?>
    <?php include ("components/rental-categories.php"); ?>
    <?php include ("components/banner.php"); ?>
    <?php include("components/cities.php"); ?>
    <?php include("components/blog.php"); ?>
    <?php include("components/footer.php"); ?>
</body>
</html>