<?php 
$conn =mysqli_connect('localhost','root','','db_onlinelibrary');
if($conn){
    echo "connected";
}
else{
    echo "error";
}
?>