<?php 

class RegisterData {
    private $fname;
    private $lname;
    private $usr_name;
    private $email;
    private $tel_num;
    private $gender;
    private $password;
    private $server_name;
    private $mysql_usr_name;
    private $mysql_password;
    private $mysql_database;
    private $response_page;

    function __construct($fname, $lname, $usr_name, $email, $tel_num, $gender, $password, $server_name, $mysql_usr_name, $mysql_password, $mysql_database, $response_page) {
        $this -> fname = $fname;
        $this -> lname = $lname;
        $this -> usr_name = $usr_name;
        $this -> email = $email;
        $this -> tel_num = $tel_num;
        $this -> gender = $gender;
        $this -> password = $password;
        $this -> server_name = $server_name;
        $this -> mysql_usr_name = $mysql_usr_name;
        $this -> mysql_password = $mysql_password;
        $this -> mysql_database = $mysql_database;
        $this -> response_page = $response_page;

        if ($fname == '' and $lname == '' and $usr_name == '' and $email == '' and $tel_num == '' and $gender == '' and $password == '') {
            echo '<p style="color: red; font-size: 14px;">These fields are required.</p>';
        } else {
            $mysqli = new mysqli($server_name, $mysql_usr_name, $mysql_password, $mysql_database);

            if ($mysqli -> connect_errno) {
                die(print_r($mysqli -> connect_error, true));
            } else {
                if ($this -> check_repeated()) {
                    echo '<p style="color: red; font-size: 14px;">You have already registered.</p>';
                } else {
                    $execute1 = "INSERT INTO registerData(first_name, last_name, username, gender, password) VALUES (?, ?, ?, ?, ?);";
                    $execute2 = "INSERT INTO registerData_email VALUES (?, ?, ?);";
                    $execute3 = "INSERT INTO registerData_telephone_number VALUES (?, ?, ?);";
                    $stmt1 = $mysqli -> prepare($execute1);
                    $stmt2 = $mysqli -> prepare($execute2);
                    $stmt3 = $mysqli -> prepare($execute3);
                    $id = $this -> ID();

                    $stmt1 -> bind_param("sssss", $fname, $lname, $usr_name, $gender, $password);
                    $stmt2 -> bind_param("iss", $id, $usr_name, $email);
                    $stmt3 -> bind_param("isi", $id, $usr_name, $tel_num);

                    if ($stmt1 -> execute() and $stmt2 -> execute() and $stmt3 -> execute()) {
                        header("location: " . (string) $response_page);
                    } else {
                        echo '<p style="color: red; font-size: 14px;">Failed to register this user!</p>';
                    }
                }
            }
        }
    }

    private function check_repeated() {

        $mysqli = new mysqli($this -> server_name, $this -> mysql_usr_name, $this -> mysql_password, $this -> mysql_database);

        if ($mysqli -> connect_errno) {
            die(print_r($mysqli -> connect_error, true));
        } else {
            $execute = sprintf('SELECT * FROM registerData WHERE username = "%s"', $this -> usr_name);
            $result = $mysqli -> query($execute);
            $registerData = $result -> fetch_assoc();

            if ($registerData["username"] == $this -> usr_name) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function ID() {
        $id = 0;
        $mysqli = new mysqli($this -> server_name, $this -> mysql_usr_name, $this -> mysql_password, $this -> mysql_database);

        if ($mysqli -> connect_errno) {
            die(print_r($mysqli -> connect_error, true));
        } else {
            $execute = sprintf('SELECT * FROM registerData WHERE username = "%s"', $this -> usr_name);
            $result = $mysqli -> query($execute);
            $registerData = $result -> fetch_assoc();
            $id = $registerData["ID"];

            if ($id == 0 or is_null($id)) {
                $id++;
            }
        }

        $id = (int) $id;

        return $id;
    }
}

$user = new RegisterData("a", "b", "c", "d", 123456, "f", "g", "sql203.infinityfree.com", "if0_37242661", "Xx12Yy34Zz56", "if0_37242661_mobher", "./authentication.php"); // Just to execute the class, not real data.

?>
