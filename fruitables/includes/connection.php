<?php
$con = mysqli_connect("localhost", "root", "", "ebook_system");

if(!$con){
    echo "connection failed" . mysqli_error();
}
?>