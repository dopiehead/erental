<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imageData = $_POST['image'];

    // Remove Base64 prefix
    $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
    $imageData = base64_decode($imageData);

    // Save the image temporarily
    $tempFile = tempnam(sys_get_temp_dir(), 'face') . '.jpg';
    file_put_contents($tempFile, $imageData);

    // Face++ API credentials
    $api_key = "4EMenTzRImcVPWlBVJoyx9RWvnTITajr"; // Replace with your Face++ API Key
    $api_secret = "U0e84BF-T4fYMUo_NN4hI9gtKmfw67-z"; // Replace with your Face++ API Secret
    $api_url = "https://api-us.faceplusplus.com/facepp/v3/detect";

    // Prepare the API request
    $postFields = [
        'api_key' => $api_key,
        'api_secret' => $api_secret,
        'image_file' => new CURLFile($tempFile),
        'return_attributes' => 'headpose,smiling'
    ];

    // cURL request to Face++ API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Delete the temp image file
    unlink($tempFile);

    // Return API response to frontend
    echo $response;
}
?>
