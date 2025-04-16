<?php
// Include the database connection file
require_once 'config/DB_Ops.php'; // Ensure correct path

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["user_image"])) {
    $uploadDir = "uploads/users/";  // Directory to store images

    // Extract file info
    $fileName = basename($_FILES["user_image"]["name"]);
    $fileTmpName = $_FILES["user_image"]["tmp_name"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate file extension
    if (!in_array($fileExt, $allowedExtensions)) {
        die("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    // Ensure directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Remove special characters from filename (sanitize)
    $originalFileName = pathinfo($fileName, PATHINFO_FILENAME); // Get filename without extension
    $originalFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalFileName); // Sanitize

    $userId = $_POST['user_id'] ?? null;

    if (!$userId) {
        echo "Error: No user ID provided";
        exit;
    }


    // Generate a unique key
    $uniqueKey = uniqid();

    // Create final filename: originalFilename_userId_uniqueKey.ext
    $newFileName = "{$originalFileName}_{$userId}_{$uniqueKey}.{$fileExt}";
    $filePath = $uploadDir . $newFileName;

    // Move file to the upload directory
    if (move_uploaded_file($fileTmpName, $filePath)) {
        // Insert only the new file name into the database
        $conn = getDbConnection();
        $stmt = $conn->prepare("UPDATE users SET user_image = ? WHERE id = ?");
        $stmt->bind_param("si", $newFileName, $userId);

        if ($stmt->execute()) {
            echo "File uploaded successfully!";
        } else {
            echo "Error updating database: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error moving the uploaded file.";
    }
}
