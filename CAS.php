<?php
$account_status = $_SESSION['account_status'];

if($account_status == 1) {
    header("Location: ./auth.php?p=acc-wfa");
    exit();
} else if($account_status == 2) {
    echo 'Full access to the site.';
} else if($account_status == 3) {
    header("Location: ./auth.php?p=acc-blocked");
    exit();
} else if($account_status == 4) {
    echo 'Your account will be deleted soon..';
}