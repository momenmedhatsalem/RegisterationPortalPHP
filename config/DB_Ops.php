<?php
    class DB_Connection {
        private $servername;
        private $username;
        private $password;
        private $db_name;

        public $conn;

        function __construct($username, $password) {
            $this->servername = "localhost";
            $this->username = $username;
            $this->password = $password;
            $this->db_name = "RegistrationPortal";

            $this->connect();
        }

        function connect() {
            $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db_name)
            or die ("couldn't connect to this host, and the error is: " . mysqli_connect_error());

            // Check if the database exists
            $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . $this->db_name;
            $result = mysqli_query($this->conn, $sql);
            if (mysqli_num_rows($result) <= 0) {
                //TODO: code to create database
            }

            //TODO: make the same logic to check if the User table exists. If not create it

            mysqli_select_db($this->conn, $this->db_name)
            or die ("couldn't open this database, and the error is: " . mysqli_error($this->conn));
        }

        function __destruct() {

        }
    };






    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {

    }
?>