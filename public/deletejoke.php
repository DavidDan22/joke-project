<?php 
try{
include __DIR__. '/../includes/DatabaseConnection.php';
include __DIR__. '/../includes/DatabaseFunctions.php';
    delete($pdo, 'joke', 'id', $_POST['id']);

header('location: jokes.php');
}
catch(PDOEXECPTION $e){
    $title= 'An Error has occured';
    $output= 'Unable to connect to database: ' . $e->getMessage() . ' in '. 
    $e->getFile(). ' : ' . $e->getLine();
}
include __DIR__ . '/../templates/layout.html.php'; 


?>