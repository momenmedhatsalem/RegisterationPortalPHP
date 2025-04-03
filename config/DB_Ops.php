<?php
    $fullName = $userName = $email = $number = $wpNumber = $address = $password = $confirmPassword = "";
    
    $errMsgs["full_name"] = "";
    $errMsgs["user_name"] = "";
    $errMsgs["email"] = "";
    $errMsgs["phone"] = "";
    $errMsgs["whatsapp"] = "";
    $errMsgs["address"] = "";
    $errMsgs["password"] = "";
    $errMsgs["confirm_password"] = "";
    $errMsgs["user_image"] = "";

    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $shouldFurtherValidate = true;
        $shouldStoreIn_db = false;

        foreach ($_POST as $key => $value)
        {
            if (!basicValidation($key, $value))
            {
                $shouldFurtherValidate = false;
            }
            $_POST[$key] = $value;
        }

        if($shouldFurtherValidate)
        {
            $fullName = $_POST["full_name"];
            $userName = $_POST["user_name"];
            $email = $_POST["email"];
            $number = $_POST["phone"];
            $wpNumber = $_POST["whatsapp"];
            $address = $_POST["address"];
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirm_password"];    

            //configure the db data
            $servername = "localhost";
            $db_username = "root";
            $db_password ="";
            $db_name = "registrationportal";
            $tableName = "users";
        
            $shouldStoreIn_db = true;
            $shouldStoreIn_db = validate_fullName($fullName) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_username($userName) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_email($email) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_phoneNumber("phone", $number/*, true*/) && $shouldStoreIn_db;
            //TODO: Check if further whatsapp number validation is needed
            $shouldStoreIn_db = validate_phoneNumber("whatsapp", $wpNumber/*, false*/) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_password($password) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_confirmPassword($confirmPassword) && $shouldStoreIn_db;
            //TODO: Image validation

            if ($shouldStoreIn_db)
            {
                //secure the password
                $password = password_hash($password, PASSWORD_DEFAULT);

                //DB-insertion section            
                $conn = mysqli_connect($servername, $db_username, $db_password)
                or die ("couldn't connect to this host, and the error is: " . mysqli_connect_error());
    
                // Check if the database exists
                $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
                mysqli_query($conn, $sql);

                //connect to the db
                mysqli_select_db($conn, $db_name)
                or die ("couldn't open this database, and the error is: " . mysqli_error($conn));

                //check if the 'users' table exists, and create it if it doesn't
                $sql = "SHOW TABLES LIKE '$tableName'";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows <= 0) {
                    $sql = "CREATE TABLE users (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        full_name VARCHAR(255) NOT NULL,
                        user_name VARCHAR(100) NOT NULL UNIQUE,
                        phone VARCHAR(20) NOT NULL UNIQUE,
                        whatsapp_number VARCHAR(20) NULL,
                        address TEXT NULL,
                        password VARCHAR(255) NOT NULL, 
                        user_image VARCHAR(500) NULL, 
                        email VARCHAR(255) NOT NULL UNIQUE,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    );";

                    mysqli_query($conn, $sql);
                }
                
                //TODO: Image-name insertion - handling
                //Important note: an arbitraty image path is stored. Not the real input. To be changed later
                //insert input into the db
                $imagePath = "hi.png";
                $query = "INSERT INTO $tableName (full_name, user_name, phone, whatsapp_number, address, password, user_image, email) VALUES ('$fullName', '$userName', '$number', '$wpNumber', '$address', '$password', '$imagePath', '$email')";
                mysqli_query($conn, $query);
                mysqli_close($conn);

                //the successful response
                echo "You have successfully registered!";
            }
            else
            {
                header('Content-Type: application/json');
                echo json_encode($errMsgs);
            }
        }
        else
        {
            header('Content-Type: application/json');
            echo json_encode($errMsgs);
        }
    }

    function basicValidation ($inputName, &$inputValue){
        if (checkRequired($inputName))
        {
            $inputValue = stripslashes($inputValue);
            $inputValue = trim($inputValue);
            $inputValue = htmlspecialchars($inputValue);
            return true;
        } else {
            return false;
        }
    }

    function checkRequired ($inputName) {
        global $errMsgs;
        if (empty($_POST[$inputName]))
        {
            $errMsgs[$inputName] = 'This field is required. Please fill it';
            return false;
        } else {
            return true;
        }
    }

    function validate_fullName ($fullName) {
        global $errMsgs;
        if (preg_match("/^([a-zA-Z]+[-.]?[ ]*){1,6}$/", $fullName))
        {
            $found_WS = false;
            for ($i = 0; $i < strlen($fullName); $i++ )
            {
                if (($fullName[$i] === ' ' || $fullName[$i] === '\n') && !$found_WS)
                {
                    $found_WS = true;
                }
                else if (($fullName[$i] === ' ' || $fullName[$i] === '\n') && $found_WS)
                {
                    //remove the extra consecutive ws
                    $fullName = substr($fullName, 0,$i) . substr($fullName, $i + 1);
                }
                else if (!($fullName[$i] === ' ' || $fullName[$i] === '\n') && $found_WS)
                {
                    $found_WS = false;
                }
            }
            return true;
        } else {
            $errMsgs["full_name"] = "Your name must contain at least one alphabetical letter and no special characters other than - . (which can't be consecutive) and spaces. Maximum till the name of the 4th grandparent";
            return false;
        }
    }

    function validate_username ($userName) {
        global $errMsgs;
        if (preg_match("/^[^\s]+$/", $userName))
        {
            // $unique = check_uniqueness('user_name', $userName);
            // if (!$unique)
            // {
            //     $errMsgs["user_name"] = "This username is already taken. Please write another one";
            //     return false;
            // }
            return true;
        } else {
            $errMsgs["user_name"] = "usernames cannot contain any whitespaces or backslashes";
            return false;
        }
    }

    function validate_email ($email) {
        global $errMsgs;
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            // $unique = check_uniqueness('email', $email);
            // if (!$unique)
            // {
            //     $errMsgs["email"] = "This email address is already used by another account. Please write another email address";
            //     return false;
            // }
            return true;
        } else {
            $errMsgs["email"] = "please enter a valid email";
            return false;
        }
    }

    function validate_phoneNumber ($fieldName, &$phoneNumber/*, $shouldCheckUniqueness*/) {
        global $errMsgs;
        if (preg_match("/^\+?[0-9]{7,15}$/", $phoneNumber)) {
            if (!$phoneNumber[0] == '+')
            {
                $char = "+";
                $phoneNumber = $char . $phoneNumber; 
            }

            // if ($shouldCheckUniqueness)
            // {
            //     $unique = check_uniqueness('phone', $phoneNumber);
            //     if (!$unique)
            //     {
            //         $errMsgs[$fieldName] = "This phone number is already used by another account. Please write another number";
            //         return false;
            //     }
            //     return true;
            // }
            return true;

        } else {
            $errMsgs[$fieldName] = "Phone number must contain only digits, and may start with a +. It must be between 7 to 15 digits";
            return false;
        }
    }

function validate_password($password)
{
    global $errMsgs;

    // Check if password is at least 8 characters long
    if (strlen($password) < 8) {
        $errMsgs["password"] = "Password must be at least 8 characters long";
        return false;
    }

    // Check for any whitespaces
    else if (preg_match("/\s+/", $password)) {
        $errMsgs["password"] = "Password must not contain any whitespaces";
        return false;
    }
    
    // Check if password contains at least 1 number
    if (!preg_match('/[0-9]/', $password)) {
        $errMsgs["password"] = "Password must contain at least 1 number";
        return false;
    }

    // Check if password contains at least 1 special character
    if (!preg_match('/[^a-zA-Z0-9\s]/', $password)) {
        $errMsgs["password"] = "Password must contain at least 1 special character";
        return false;
    }

    return true;
}

function validate_confirmPassword($confirmPassword)
{
    global $errMsgs;

    // Check if passwords match
    if ($confirmPassword !== $_POST["password"]) {
        $errMsgs["confirm_password"] = "Passwords do not match";
        return false;
    }

    return true;
}

//     function check_uniqueness ($field, $value) {
//         global $servername, $db_username, $db_password, $db_name, $tableName;

//         $connect = mysqli_connect($servername, $db_username, $db_password, $db_name)
//         or die ("couldn't connect to this host or database, and the error is: " . mysqli_connect_error());
    
//         $query = "SELECT * FROM $tableName WHERE $field = ?";
//         $stmt = mysqli_prepare($connect, $query)
//         or die ("couldn't prepare this query, and the error is: " . mysqli_error($connect));
        
//         mysqli_stmt_bind_param($stmt, "s", $value);
//         mysqli_stmt_execute($stmt);
//         $result = mysqli_stmt_get_result($stmt);
    
//         $isAvailable = mysqli_num_rows($result) == 0; // If no record exists, it's available
//         mysqli_stmt_close($stmt);
//         mysqli_close($connect);
    
//         return $isAvailable;
//     }
?>