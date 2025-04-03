<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["field"]) && isset($_POST["value"])) {
    $field = $_POST["field"];
    $value = $_POST["value"];

    if (in_array($field, ["user_name", "email", "phone"])) {
        $isUnique = check_uniqueness($field, $value);
        echo json_encode(["status" => "success", "available" => $isUnique]);
        exit();
    }
}

// Function to check uniqueness in the database
function check_uniqueness($field, $value) {
    $connect = mysqli_connect("localhost", "root", "", "registrationportal");

    if (!$connect) {
        echo json_encode(["status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()]);
        exit();
    }

    $query = "SELECT * FROM users WHERE $field = ?";
    $stmt = mysqli_prepare($connect, $query);

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Query preparation failed: " . mysqli_error($connect)]);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $value);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $isAvailable = mysqli_num_rows($result) == 0; // If no record exists, it's available
    mysqli_stmt_close($stmt);
    mysqli_close($connect);

    return $isAvailable;
}
?>
