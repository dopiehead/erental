<?php
// report_product.php - Handles product report form submissions

// Set headers for JSON response
header('Content-Type: application/json');

// Initialize database connection
function connectToDatabase() {
   require("engine/config.php");
}

// Sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Main processing function
function processReport() {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return ['success' => false, 'message' => 'Invalid request method'];
    }
    
    // Required fields
    $requiredFields = ['product_id', 'issue_type', 'description'];
    
    // Check for required fields
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            return ['success' => false, 'message' => "Missing required field: $field"];
        }
    }
    
    // Sanitize and validate input
    $productId = sanitizeInput($_POST['product_id']);
    $issueType = sanitizeInput($_POST['issue_type']);
    $description = sanitizeInput($_POST['description']);
    $customerEmail = isset($_POST['customer_email']) ? sanitizeInput($_POST['customer_email']) : '';
    
    // Validate product ID (assuming numeric)
    if (!is_numeric($productId)) {
        return ['success' => false, 'message' => 'Invalid product ID'];
    }
    
    // Validate email if provided
    if (!empty($customerEmail) && !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }
    
    // Validate description length
    if (strlen($description) < 10) {
        return ['success' => false, 'message' => 'Description is too short (minimum 10 characters)'];
    }
    
    // Connect to the database
    $pdo = connectToDatabase();
    if ($pdo === null) {
        return ['success' => false, 'message' => 'Database connection error'];
    }
    
    try {
        // Insert report into database
        $stmt = $pdo->prepare("
            INSERT INTO product_reports 
            (product_id, issue_type, description, customer_email, reported_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([$productId, $issueType, $description, $customerEmail]);
        $reportId = $pdo->lastInsertId();
        
        // Log the report creation
        error_log("New product report created: ID $reportId for product $productId");
        
        // Send notification email to admin if applicable
        // sendNotificationEmail($reportId, $productId, $issueType);
        
        return [
            'success' => true, 
            'message' => 'Report submitted successfully',
            'report_id' => $reportId
        ];
        
    } catch (PDOException $e) {
        error_log("Error saving product report: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to save report'];
    }
}

// Process the report and output the result as JSON
$result = processReport();
echo json_encode($result);