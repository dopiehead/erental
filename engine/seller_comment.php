<?php session_start();

require("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $product_name = isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '';
     $sender_email = isset($_POST['sender_email']) ? htmlspecialchars($_POST['sender_email']) : '';
     $sender_name = isset($_POST['sender_name']) ? htmlspecialchars($_POST['sender_name']) : '';
     $comment = isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '';
     $date = date('Y-m-d H:i:s');

    if (empty($product_name) || empty($sender_email) || empty($sender_name) || empty($comment)) {
         echo "error"; // Return error if any field is empty
         exit;
    }

     $stmt = $conn->prepare("INSERT INTO comments (product_name, sender_email, sender_name, comment, date) VALUES (?, ?, ?, ?, ?)");
     $stmt->bind_param("sssss", $product_name, $sender_email, $sender_name, $comment, $date);

    if ($stmt->execute()) {
         echo "1"; // Return success if the comment was added
    } else {
         echo "error"; // Return error if there was an issue inserting into the database
    }

     $stmt->close();
     $conn->close();
} else {
    echo "error"; // If the request is not a POST request, return an error
}
?>
