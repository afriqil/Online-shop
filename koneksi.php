<?php
    $localhost = "localhost:3306";

    $con = mysqli_connect($localhost, "root", "", "pos_shop");

    if (mysqli_connect_errno()) {
        echo "failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
?>