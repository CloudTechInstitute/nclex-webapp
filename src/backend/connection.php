<?php
$conn = mysqli_connect('localhost', 'globpvlr_user', 'globalnclexexamscenter', 'globpvlr_content-center');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}