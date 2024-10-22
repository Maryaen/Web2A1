<?php

/*To Do List:
    - divide driver details & race results 
    - make the nav bar
    - make table headers further apart
    - make it pretty (CSS)
*/

include 'db_connection.php';

if (isset($_GET['driverRef'])) {
    $driverRef = $_GET['driverRef'];

    $statement = $pdo->prepare("
    SELECT driverId, forename, surname, dob, url, nationality
    FROM drivers WHERE driverRef = ?"); 
    $statement->bindValue(1, $driverRef);
    $statement->execute();
    $driver = $statement->fetch(PDO::FETCH_ASSOC);

    if ($driver) {
        $statementResults = $pdo->prepare("SELECT r.raceId, r.name AS raceName, r.round, c.name AS circuitName, rs.positionText, rs.points FROM results rs
        INNER JOIN races r ON rs.raceId = r.raceId INNER JOIN circuits c ON r.circuitId = c.circuitId WHERE rs.driverId = ? AND r.year = 2022 ORDER BY r.round");
        $statementResults->bindValue(1, $driver['driverId']);
        $statementResults->execute();
        $results = $statementResults->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Driver</title>
</head>
<header>
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
<body>
    <div class = nav>
    <h1>Formula 1</h1>
    </div>
    <div>
        <h2>Driver Details</h2>
        <?php if (isset($driver) && $driver): ?>
        <h3><?php echo htmlspecialchars($driver['forename'] . ' ' . $driver['surname']); ?></h3>
        <strong>Nationality: </strong><?php echo htmlspecialchars($driver['nationality']); //edit to be bold in css instead ?>
        <p>Date of Birth: <?php echo htmlspecialchars($driver['dob']); ?></p>
        <p>Want to know more?: <a href="<?php echo htmlspecialchars($driver['url']); ?>"> Click Me!</a></p>
        <?php endif; ?>
    </div>

    <div>
    <h2>Race Results</h2>
    <table class = "alternate">
        <thead id = "tableHead">
            <tr id = "tableHead">
                <th>Round</th>
                <th>Circuit</th>
                <th>Position</th>
                <th>Points</th>
            </tr>
        </thead>
            <?php
            if (isset($results) && !empty($results)) {
                foreach ($results as $result) {
                    echo '<tr>' .
                         '<td>' . htmlspecialchars($result['round']) . '</td>' .
                         '<td>' . htmlspecialchars($result['circuitName']) . '</td>' .
                         '<td>' . htmlspecialchars($result['positionText']) . '</td>' .
                         '<td>' . htmlspecialchars($result['points']) . '</td>' .
                         '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No race results available.</td></tr>';
            } ?>
    </table>
    </div>
</body>
</html>