<?php
include_once('classes/clients.php');
$clients = new clients();

// display the clients form
if(isset($_GET['displayClientForm']) && $_GET['displayClientForm'] && isset($_GET['hk']) && password_verify('displayClientForm', $_GET['hk'])){
    echo $clients->clientFormDisplay();
}
// inserts a new client into the DB
if(isset($_GET['addClientInfo']) && isset($_POST['ClientInfo']) && $_GET['addClientInfo'] && $_POST['ClientInfo'] && isset($_GET['hk']) && password_verify('addClientInfo', $_GET['hk'])){
    echo $clients->addClient($_POST['ClientInfo']);
}
// displays the update client form
if(isset($_GET['editClientForm']) && $_GET['editClientForm'] && isset($_GET['clientID']) && $_GET['clientID'] && isset($_GET['hk']) && password_verify('editClientForm', $_GET['hk'])){
    echo $clients->clientFormDisplay($_GET['clientID']);
}
// updates a client into the DB
if(isset($_GET['updateClientInfo']) && isset($_POST['ClientInfo']) && $_GET['updateClientInfo'] && $_POST['ClientInfo'] && isset($_GET['hk']) && password_verify('updateClientInfo', $_GET['hk'])){
    echo $clients->updateClientInfo($_POST['ClientInfo']);
}
// client search
if(isset($_GET['searchClient']) && isset($_GET['searchTerm']) && isset($_GET['filter']) && $_GET['searchClient'] && $_GET['searchTerm'] && $_GET['filter'] && isset($_GET['hk']) && password_verify('searchClient', $_GET['hk'])){
    $response = $clients->searchClientInfo($_GET['searchTerm'], $_GET['filter']);
    echo json_encode($response);
}

// updates a client into the DB
if(isset($_GET['deleteClientInfo']) && isset($_GET['clientID']) && $_GET['deleteClientInfo'] && $_GET['clientID'] && isset($_GET['hk']) && password_verify('deleteClientInfo', $_GET['hk'])){
    echo $clients->deleteClientInfo($_GET['clientID']);
}