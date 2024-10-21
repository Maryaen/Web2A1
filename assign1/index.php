<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
<header>
        <h1>Formula 1</h1>
        <nav>
            <ul class = "navi">
                <li><a href="index.php">Home</a></li>
                <li><a href="browse.php">Browse Races</a></li>
                <li><a href="">API Page</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <div>
            <h2>About This Website</h2>
            <p>
                This website allows you to go through information about Formula 1, including drivers, constructors, circuits, and races.
                You can learn about specific drivers or constructors, and race results! Want to look through it yourself? 
                <div class="browse-button">
                <a href="browse.php">
                    <button type="button">Browse</button>
                </a>
            </div>
            </p>
    </div>
    </main>

    <div>
    

</body>
</html>
