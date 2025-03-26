<?php
require("config.php");

$myid = $_POST['user_id'];
$date = date("Y-m-d H:i:s");
$imageFolder = "../uploads/users/verification/";
$maxsize = 4 * 1024 * 1024; // 4MB limit
$allowed_extensions = ["jpg", "jpeg", "png"];

// Handle Passport Upload
if (!isset($_FILES["passport"])) {
    die("Passport file is required.");
}

$passport_name = basename($_FILES["passport"]["name"]);
$passport_path = $imageFolder . $passport_name;
$passport_ext = strtolower(pathinfo($passport_path, PATHINFO_EXTENSION));

if (!in_array($passport_ext, $allowed_extensions)) {
    die("Passport must be a PNG or JPEG file.");
}

if ($_FILES["passport"]["size"] > $maxsize) {
    die("Passport file size exceeds 4MB.");
}

if (!move_uploaded_file($_FILES["passport"]["tmp_name"], $passport_path)) {
    die("Failed to upload passport.");
}

// Handle Valid ID Upload
if (!isset($_FILES["valid_id"])) {
    die("Valid ID file is required.");
}

$valid_id_name = basename($_FILES["valid_id"]["name"]);
$valid_id_path = $imageFolder . $valid_id_name;
$valid_id_ext = strtolower(pathinfo($valid_id_path, PATHINFO_EXTENSION));

if (!in_array($valid_id_ext, $allowed_extensions)) {
    die("Valid ID must be a PNG or JPEG file.");
}

if ($_FILES["valid_id"]["size"] > $maxsize) {
    die("Valid ID file size exceeds 4MB.");
}

if (!move_uploaded_file($_FILES["valid_id"]["tmp_name"], $valid_id_path)) {
    die("Failed to upload valid ID.");
}

// Insert into database
$sql = "INSERT INTO proof_of_identity (user_id, passport, valid_id, date_added) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $myid, $passport_name, $valid_id_name, $date);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error in uploading images: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
