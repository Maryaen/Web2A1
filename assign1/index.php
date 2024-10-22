<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS and dependencies (Optional for interactive components like dropdowns, modals) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Home</title>
</head>

<body>
<header>
    <? //bootsrap link: https://getbootstrap.com/docs/4.0/components/navbar/ - used for all the webpages so ill just mention it here?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Formula 1</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="browse.php">Browse</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="">API Page</a>
      </li>
    </ul>
  </div>
</nav>
    </header>
    <main style="background-color:  #f8f9fa">
    <div>
            <h2>About This Website</h2>
            <br><br>
            <p>
                This website allows you to go through information about Formula 1, including drivers, constructors, circuits, and races.
                You can learn about specific drivers or constructors, and race results! Want to look through it yourself? 
                <div class="browse-button">
                    <br>
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
