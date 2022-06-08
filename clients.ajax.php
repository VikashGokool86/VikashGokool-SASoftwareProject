<?php
include_once('classes/clients.php');

$clients = new clients();


// Inserts clients into DB
if(isset($_GET['ClientInfo']) && isset($_POST['ClientInfo']) && isset($_GET['hk']) && password_verify('ClientInfo', $_GET['hk'])){
    $respond = $clients->addClient($_POST['ClientInfo']);
    if($respond){
        header("Location: index.php");
        exit();
    }

}