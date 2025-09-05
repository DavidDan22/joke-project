<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
</head>
<body> 
    <header> 
        <h1>Internet Joke Database</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="jokes.php">Jokes</a></li>
             <li><a href="editjoke.php">Add Jokes</a></li>
        </ul>
    </nav>
    <main>
        <?=$output?>
    </main>

</body>
<footer>
    &copy; IJDB 2025
</footer>
</html>