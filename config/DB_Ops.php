<?php
    //include __DIR__ . '../app/services/API_Ops.php';

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
        }

        $fullName = $_POST["full_name"];
        $userName = $_POST["user_name"];
        $email = $_POST["email"];
        $number = $_POST["phone"];
        $wpNumber = $_POST["whatsapp"];
        $address = $_POST["address"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];

        if($shouldFurtherValidate)
        {
            $shouldStoreIn_db = true;
            $shouldStoreIn_db = $shouldStoreIn_db && validate_fullName($fullName);
            $shouldStoreIn_db = $shouldStoreIn_db && validate_username($userName);
            $shouldStoreIn_db = $shouldStoreIn_db && validate_email($email);
            $shouldStoreIn_db = $shouldStoreIn_db && validate_phoneNumber($number);
            $shouldStoreIn_db = $shouldStoreIn_db && validate_whatsappPhoneNumber($wpNumber);
            $shouldStoreIn_db = $shouldStoreIn_db && validate_password($password);
            $shouldStoreIn_db = $shouldStoreIn_db && validate_confirmPassword($confirmPassword);
        }

        if ($shouldStoreIn_db)
        {
            $servername = "localhost";
            $username = "root";
            $password ="";
            $db_name = "registrationportal";
            $tableName = "users";
        
            $conn = mysqli_connect($servername, $username, $password)
            or die ("couldn't connect to this host, and the error is: " . mysqli_connect_error());

            // Check if the database exists
            $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . $db_name;
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) <= 0) {
                //TODO: code to create database
            }

            mysqli_select_db($conn, $db_name)
            or die ("couldn't open this database, and the error is: " . mysqli_error($conn));
            
            //user_image, before email
            $sql = "INSERT INTO " . $tableName . "(full_name, user_name, phone, whatsapp_number, address, password, email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $fullname, $userName, $number, $wpNumber, $address, $password, $email);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    function basicValidation ($inputName, &$inputValue){
        if (checkRequired($inputName))
        {
            $inputValue = trim($inputValue);
            if (!preg_match("/.*[password|user_name]+.*/", $inputName))
            {
                $inputValue = stripslashes($inputValue);
            }
            $inputValue = htmlspecialchars($inputValue);
            return true;
        } else {
            return false;
        }
    }

    function checkRequired ($inputName) {
        if (empty($_POST[$inputName]))
        {
            $errMsgs[$inputName] = 'This field is required. Please fill it';
            return false;
        } else {
            return true;
        }
    }

    function validate_fullName ($fullName) {
        if (preg_match("/^(?=.*[a-zA-Z])[a-zA-Z -']*$/", $fullName))
        {
            return true;
        } else {
            $errMsgs["full_name"] = "Your name must contain at least one alphabetical letter and no special characters other than - ' and space";
            return false;
        }
    }

    function validate_username ($userName) {
        if (preg_match("/^[^\s]+$/", $userName))
        {
            //TODO: check it's uniqueness from the DB
        } else {
            $errMsgs["user_name"] = "usernames cannot contain any whitespaces";
            return false;
        }
    }

    function validate_email ($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        } else {
            $errMsgs["email"] = "please enter a valid email";
            return false;
        }
    }

    function validate_phoneNumber ($phoneNumber) {
        if (preg_match("/\+[0-9]{7,15}/", $phoneNumber)) {
            return true;
        } else {
            $errMsgs["phone"] = "please enter your phone in the international format (starting with a +) and without any separating special characters between digits";
            return false;
        }
    }

    function validate_whatsappPhoneNumber ($WP_phoneNumber) {
        if (validate_phoneNumber($WP_phoneNumber) && validateWhatsAppNumber($WP_phoneNumber))
        {
            return true;
        } else {
            return false;
        }
    }

    function validate_password ($password) {
        //TODO
    }

    function validate_confirmPassword ($confirmPassword) {
        //TODO
    }
?>