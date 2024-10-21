<?php
include 'assign1\db_connection.php'; //also not working

header('Content-Type: application/json');

if (isset($_GET['constructorRef'])) {
    $constructorRef = $_GET['constructorRef'];
    $statement = $pdo->prepare("SELECT constructorId, name, nationality, url FROM constructors WHERE constructorRef = ?");
    $statement->bindValue(1, $constructorRef);
} else {
    $statement = $pdo->prepare("SELECT constructorId, name, nationality, url FROM constructors");
}

$statement->execute();
$constructors = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['status' => 'success', 'data' => $constructors]);
?>
