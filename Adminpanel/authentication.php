<?php
class authentication {
    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function login($username, $password) {
        $user_data = $this->user->authenticate($username, $password);

        if ($user_data) {
            session_start();
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['login'] = true;
            header('location: Adminpanel/index.php');
            exit;
        } else {
            return "Kombinasi username dan password tidak valid.";
        }
    }
}
