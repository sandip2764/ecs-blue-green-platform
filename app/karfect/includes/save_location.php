<?php
session_start();
if (isset($_POST['selected_location']) && isset($_POST['pincode'])) {
    $_SESSION['selected_location'] = $_POST['selected_location'];
    $_SESSION['pincode'] = $_POST['pincode'];
    echo 'success';
} else {
    echo 'error';
}
?>