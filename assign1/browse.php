<?php

include 'db_connection.php';

$statement = $pdo->prepare("SELECT raceId, name, round FROM races WHERE year = 2022 ORDER BY round");
$statement->execute();
$races = $statement->fetchAll(PDO::FETCH_ASSOC);

$raceSelected = [];
$qualifyingResults = [];
$raceResults = [];

if (isset($_GET['raceId'])) {
    $raceId = $_GET['raceId'];

    $raceSQL = $pdo->prepare("SELECT r.name AS raceName, r.round, c.name AS circuitName, c.location, c.country 
        FROM races r
        INNER JOIN circuits c ON r.circuitId = c.circuitId
        WHERE r.raceId = ?
    ");
    $raceSQL->bindValue(1, $raceId);
    $raceSQL->execute();
    $raceSelected = $raceSQL->fetch(PDO::FETCH_ASSOC);

    $qualifyingSQL = $pdo->prepare("SELECT d.forename, d.surname, d.driverRef, c.constructorRef, c.name AS constructorName, q.position, q.q1, q.q2, q.q3
    FROM qualifying q
    INNER JOIN drivers d ON q.driverId = d.driverId
    INNER JOIN constructors c ON q.constructorId = c.constructorId
    WHERE q.raceId = ?
    ORDER BY q.position
");

    $qualifyingSQL->bindValue(1, $raceId);
    $qualifyingSQL->execute();
    $qualifyingResults = $qualifyingSQL->fetchAll(PDO::FETCH_ASSOC);

    $resultsSQL = $pdo->prepare("SELECT d.forename, d.surname, d.driverRef, rs.positionText, rs.laps, rs.points, c.name AS constructorName
        FROM results rs
        INNER JOIN drivers d ON rs.driverId = d.driverId
        INNER JOIN constructors c ON rs.constructorId = c.constructorId
        WHERE rs.raceId = ?
        ORDER BY rs.positionOrder
    ");
    $resultsSQL->bindValue(1, $raceId);
    $resultsSQL->execute();
    $raceResults = $resultsSQL->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Browse</title>
</head>
<body>
    <div class = nav>
        <h1>Formula 1</h1>
    </div>

    <aside>
        <h2>2022 Races</h2>
        <ul>
            <?php foreach ($races as $race): ?>
                <li>
                    <?php echo htmlspecialchars($race['round']) . '. ' . htmlspecialchars($race['name']); ?>
                    <a href="browse.php?raceId=<?php echo htmlspecialchars($race['raceId']); ?>">
                        <button>View</button> <?php //add left margins for buttons ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    
    <main>
    <?php if (!empty($raceSelected)): ?>
        <div>
            <h2>Qualifying</h2>
            <table>
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Driver</th>
                        <th>Constructor</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                    </tr>
                </thead>

                    <?php if (!empty($qualifyingResults)): ?>
                        <?php foreach ($qualifyingResults as $result): ?>

                            <tr>
                                <td><?php echo htmlspecialchars($result['position']); ?></td>

                                <td>
                                <a href="driver.php?driverRef=<?php echo urlencode($result['driverRef']); ?>">
                                <?php echo htmlspecialchars($result['forename'] . ' ' . $result['surname']); ?></a>
                                </td>

                                <td>
                                <a href="constructor.php?constructorRef=<?php echo urlencode($result['constructorRef']); ?>">
                                <?php echo htmlspecialchars($result['constructorName']); ?></a>
                                </td>

                                <td><?php echo htmlspecialchars($result['q1']); ?></td>

                                <td><?php echo htmlspecialchars($result['q2']); ?></td>

                                <td><?php echo htmlspecialchars($result['q3']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No qualifying results available.</td></tr>
                    <?php endif; ?>
            </table>
        </div>

        <div>
            <h2>Results</h2>
        </div>
        <?php else:?>
        <p>Please select a race to display qualifyign and results </p>
        <?php endif; ?>
    </main>
</body>
</html>