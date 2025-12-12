<?php
$con = mysqli_connect("localhost", "root", "", "ebook_system_new");

if(!$con){
    echo "connection failed" . mysqli_error();
}
?>