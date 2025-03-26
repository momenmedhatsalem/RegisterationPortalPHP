<?php
// Include the database connection file
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $uploadDir = "uploads/users/";  // Directory to store images
    $fileName = basename($_FILES["file"]["name"]);  // Get the original file name
    $fileTmpName = $_FILES["file"]["tmp_name"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Extract file extension

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

    // Generate a unique file name to avoid overwriting
    $newFileName = uniqid('user_', true) . '.' . $fileExt;
    $filePath = $uploadDir . $newFileName;

    // Move file to the upload directory
    if (move_uploaded_file($fileTmpName, $filePath)) {
        // Insert only the new file name into the database
        $stmt = $conn->prepare("UPDATE users SET user_image = ? WHERE id = ?");
        $stmt->bind_param("si", $newFileName, $userId);

        if ($stmt->execute()) {
            echo "File uploaded successfully!";
        } else {
            echo "Error uploading file: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error moving the uploaded file.";
    }
}
?>
