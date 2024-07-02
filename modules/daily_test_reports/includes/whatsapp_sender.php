<?php

// Replace these values with your actual WhatsApp API details
$apiKey = 'your_api_key_here'; // Your API Key
$apiSecret = 'your_api_secret_here'; // Your API Secret
$fromNumber = 'whatsapp_number_here'; // Your WhatsApp number in international format, e.g., +1234567890

// Function to send WhatsApp message
function sendWhatsAppMessage($toNumber, $message) {
    global $apiKey, $apiSecret, $fromNumber;

    // API URL to send WhatsApp message
    $url = "https://api.chat-api.com/instance/{$apiKey}/message";

    // Prepare message data
    $data = [
        'phone' => $toNumber,
        'body' => $message
    ];

    // Encode data to JSON
    $dataJson = json_encode($data);

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($dataJson)
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session and fetch response
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Decode JSON response
    $responseData = json_decode($response, true);

    // Check if message sent successfully
    if (isset($responseData['sent']) && $responseData['sent']) {
        return true; // Message sent successfully
    } else {
        return false; // Failed to send message
    }
}
