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

            $shouldStoreIn_db = true;
            $shouldStoreIn_db = validate_fullName($fullName) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_username($userName) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_email($email) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_phoneNumber($number) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_whatsappPhoneNumber($wpNumber) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_password($password) && $shouldStoreIn_db;
            $shouldStoreIn_db = validate_confirmPassword($confirmPassword) && $shouldStoreIn_db;
            //TODO: Image validation

            if ($shouldStoreIn_db)
            {
                $servername = "localhost";
                $db_username = "root";
                $db_password ="";
                $db_name = "registrationportal";
                $tableName = "users";
            
                $conn = mysqli_connect($servername, $db_username, $db_password)
                or die ("couldn't connect to this host, and the error is: " . mysqli_connect_error());
    
                // Check if the database exists
                $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) <= 0) {
                    //TODO: code to create database
                }
    
                mysqli_select_db($conn, $db_name)
                or die ("couldn't open this database, and the error is: " . mysqli_error($conn));

                //TODO: Code to check if the 'users' table exists, and create it if it doesn't
                //Use this code to create it:
                /*CREATE TABLE users (
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
                );*/
                
                //Alternate code: to be deleted
                    //user_image, before email
                    /*$sql = "INSERT INTO " . $tableName . "(full_name, user_name, phone, whatsapp_number, address, password, email)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "ssssssss", $fullname, $userName, $number, $wpNumber, $address, $password, $email);
                    mysqli_stmt_execute($stmt);
        
                    mysqli_stmt_close($stmt);*/
                //

                //TODO: Image-name insertion - handling
                //Important note: an arbitraty image path is stored. Not the real input. To be changed later
                $imagePath = "hi.png";
                $query = "INSERT INTO $tableName (full_name, user_name, phone, whatsapp_number, address, password, user_image, email) VALUES ('$fullName', '$userName', '$number', '$wpNumber', '$address', '$password', '$imagePath', '$email')";
                mysqli_query($conn, $query);
                mysqli_close($conn);

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
            $errMsgs["full_name"] = "Your name must contain at least one alphabetical letter and no special characters other than - . (which can't be consecutive) and space. Maximum till the name of the 5th grandparent";
            return false;
        }
    }

    function validate_username ($userName) {
        global $errMsgs;
        if (preg_match("/^[^\s]+$/", $userName))
        {
            $unique = check_uniqueness('user_name', $userName);
            if (!$unique)
            {
                $errMsgs["user_name"] = "This username is already taken. Please write another one";
                return false;
            }
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
            $unique = check_uniqueness('email', $email);
            if (!$unique)
            {
                $errMsgs["email"] = "This email address is already used by another account. Please write another email address";
                return false;
            }
            return true;
        } else {
            $errMsgs["email"] = "please enter a valid email";
            return false;
        }
    }

    function validate_phoneNumber (&$phoneNumber) {
        global $errMsgs;
        if (preg_match("/^\+?[0-9]{7,15}$/", $phoneNumber)) {
            if (!$phoneNumber[0] == '+')
            {
                $char = "+";
                $phoneNumber = $char . $phoneNumber; 
            }

            $unique = check_uniqueness('phone', $phoneNumber);
            if (!$unique)
            {
                $errMsgs["phone"] = "This phone number is already used by another account. Please write another number";
                return false;
            }
            return true;
        } else {
            $errMsgs["phone"] = "Phone number must contain only digits, and may start with a +. It must be between 7 to 15 digits";
            return false;
        }
    }

    function validate_whatsappPhoneNumber ($WP_phoneNumber) {
        //TODO: Integrate with the Wp API
        global $errMsgs;
        if (validate_phoneNumber($WP_phoneNumber))
        {
            return true;
        } else {
            return false;
        }
    }

    function validate_password ($password) {
        //TODO
        return true;
    }

    function validate_confirmPassword ($confirmPassword) {
        return true;
        //TODO
    }

    function check_uniqueness ($attribute, $value) {
        //TODO
        return true;
    }
?>