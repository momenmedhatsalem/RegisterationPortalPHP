<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

loadEnv(__DIR__ . '/../../.env');


function validateWhatsAppNumber($number) {
    if (!$number) {
        http_response_code(400);
        header('Content-Type: application/json');

        return json_encode(["status" => "error", "message" => "Number is required"]);
    }

    $url = 'https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItBulkWithToken';

    $data = json_encode([
        'phone_numbers' => [$number] 
    ]);
    $headers = [
        'Content-Type: application/json',
        'X-RapidAPI-Key: ' .  getenv('X-RapidAPI-Key'),
        'X-RapidAPI-Host: ' .  getenv('X-RapidAPI-Host')
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);


    curl_close($curl);

    if ($response === false) {      
          http_response_code(500);
          header('Content-Type: application/json');
        return json_encode(["status" => "error", "message" => "Unexpected error. Please try again later."]);
    }

    // Format response
    header('Content-Type: application/json');
    $responseData = json_decode($response, true);
    if (!empty($responseData) && isset($responseData[0]['status'])) {
        http_response_code(200);
        header('Content-Type: application/json');
        return json_encode([
            "status" => $responseData[0]['status'],
            "phone_number" => trim($responseData[0]['phone_number'])
        ]);
    } else {
        http_response_code(500);
        header('Content-Type: application/json');
        return json_encode(["status" => "error", "message" => "Invalid response from API"]);
    }
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number']??null ;
    header('Content-Type: application/json');
    echo validateWhatsAppNumber($number);
}

