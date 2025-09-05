<?php  

try {
 include __DIR__. '/../includes/DatabaseConnection.php';
 include __DIR__. '/../includes/DatabaseFunctions.php';

$jokes=allJokes($pdo);

$title='Joke List';
$totaljokes=totaljokes($pdo);

ob_start();
include __DIR__ .'/../templates/jokes.html.php';
$output= ob_get_clean();
}
catch (PDOException $e) {
 $error = 'Unable to connect to the database ' . $e->getMessage(). ' in '. 
 $e->getFile() . ':' . $e->getLine();

}
include __DIR__ . '/../templates/layout.html.php';
?> 