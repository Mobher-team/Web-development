<?php

require "register_user.php";

class Authenticate extends RegisterData {

    private $server_name;
    private $mysql_usr_name;
    private $mysql_password;
    private $mysql_database;
    private $response_page;
    function __construct($email, $password, $server_name, $mysql_usr_name, $mysql_password, $mysql_database, $response_page) {
        $this -> email = $email;
        $this -> password = $password;
        $this -> server_name = $server_name;
        $this -> mysql_usr_name = $mysql_usr_name;
        $this -> mysql_password = $mysql_password;
        $this -> mysql_database = $mysql_database;
        $this -> response_page = $response_page;

        if ($email == "" and $password == "") {
            echo '<p style="color: red; font-size: 14px;">These fields are required.</p>';
        } else {
            $mysqli = new mysqli($server_name, $mysql_usr_name, $mysql_password, $mysql_database);

            if ($mysqli -> connect_errno) {
                die(print_r($mysqli -> error, true));
            } else {
                $execute1 = sprintf('SELECT * FROM registerData WHERE password = "%s"', $password);
                $execute2 = sprintf('SELECT * FROM registerData_email WHERE email = "%s"', $email);
                $result1 = $mysqli -> query($execute1);
                $result2 = $mysqli -> query($execute2);
                $registerData = $result1 -> fetch_assoc();
                $registerData_email = $result2 -> fetch_assoc();

                if ($password == $registerData["password"] and $email == $registerData_email["email"]) {
                    header("location: " . (string) $response_page);
                } else {
                    echo '<p style = "position: absolute; bottom: 0; color: red;">Wrong password.</p>';
                }
            }
        }
    }
}

$user = new Authenticate("a", "g", "sql203.infinityfree.com", "if0_37242661", "Xx12Yy34Zz56", "if0_37242661_mobher", "www.google.com");  // Just to execute the class, not real data.

?>
