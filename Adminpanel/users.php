<?php
class User {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function authenticate($username, $password) {
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
        $countdata = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);

        if ($countdata > 0 && password_verify($password, $data['password'])) {
            return $data;
        } else {
            return false;
        }
    }
}
