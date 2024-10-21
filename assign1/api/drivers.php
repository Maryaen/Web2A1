<?php
include '../db_connection.php'; //not connecting

header('Content-Type: application/json');

if (isset($_GET['driverRef'])) {
    $driverRef = $_GET['driverRef'];
    $statement = $pdo->prepare("SELECT driverId, forename, surname, nationality, dob, url FROM drivers WHERE driverRef = ?");
    $statement->bindValue(1, $driverRef);
} else {
    $statement = $pdo->prepare("SELECT driverId, forename, surname, nationality, dob, url FROM drivers");
}

$statement->execute();
$drivers = $statement->fetchAll(PDO::FETCH_ASSOC);


echo json_encode(['status' => 'success', 'data' => $drivers]);
?>
