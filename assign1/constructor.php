<?php

/*To Do List:
    - divide constructor details & constructor results 
    - make the nav bar
    - make table headers further apart
    - make it pretty (CSS)
*/

include 'db_connection.php';

if (isset($_GET['constructorRef'])) {
    $constructorRef = $_GET['constructorRef'];

    $statement = $pdo->prepare("SELECT constructorId, nationality, name, url FROM constructors WHERE constructorRef = ?");
    $statement->bindValue(1, $constructorRef);
    $statement->execute();
    $construct = $statement->fetch(PDO::FETCH_ASSOC);

    if ($construct) {
        $statementResults = $pdo->prepare(
            "SELECT r.raceId, r.round, r.name AS raceName, c.name AS circuitName, d.forename, d.surname, rs.positionText, rs.points
            FROM results rs
            INNER JOIN races r ON rs.raceId = r.raceId
            INNER JOIN circuits c ON r.circuitId = c.circuitId
            INNER JOIN drivers d ON rs.driverId = d.driverId
            WHERE rs.constructorId = ? AND r.year = 2022
            ORDER BY r.round, d.driverId");
        $statementResults->bindValue(1, $construct['constructorId']);
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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Constructor</title>
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

    <div>
        <h2>Constructor Details</h2>
        <?php if (isset($construct) && $construct): ?>
        <h3><?php echo htmlspecialchars($construct['name']); ?></h3>
        <strong>Nationality: </strong><?php echo htmlspecialchars($construct['nationality']); //edit to be bold in css instead ?>
        <p>Want to know more? <a href="<?php echo htmlspecialchars($construct['url']); ?>"> Click Me!</a></p>
        <?php endif; ?>
    </div>

    <div>
        <h2>Race Results</h2>
        <table class = "alternate">
        <thead id = "tableHead">
            <tr id = "tableHead">
                <th>Round</th>
                <th>Circuit</th>
                <th>Drivers</th>
                <th>Position</th>
                <th>Points</th>
            </tr>
        </thead>
            <?php
            if (isset($results) && !empty($results)) {
                $currRound = 0;
                foreach ($results as $result) {
                    if ($currRound !== $result['round']) {
                        $currRound = $result['round'];
                        echo '<tr>' .
                             '<td>' . htmlspecialchars($result['round']) . '</td>' .
                             '<td>' . htmlspecialchars($result['circuitName']) . '</td>' .
                             '<td>' . htmlspecialchars($result['forename'] . ' ' . $result['surname']) . '</td>' .
                             '<td>' . htmlspecialchars($result['positionText']) . '</td>' .
                             '<td>' . htmlspecialchars($result['points']) . '</td>' .
                             '</tr>';
                    } else {
                        echo '<tr>' .
                             '<td></td>'.
                             '<td></td>'.
                             '<td>' . htmlspecialchars($result['forename'] . ' ' . $result['surname']) . '</td>' .
                             '<td>' . htmlspecialchars($result['positionText']) . '</td>' .
                             '<td>' . htmlspecialchars($result['points']) . '</td>' .
                             '</tr>';
                    }
                }
            } else {
                echo '<tr><td colspan="5">No race results available for this constructor in 2022.</td></tr>';
            }
            ?>
    </table>
    </div>
</body>
</html>