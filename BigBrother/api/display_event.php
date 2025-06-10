<?php
include('../includes/auth.php');
include('../includes/db.php');

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM calendar_event_master WHERE user_id = ?");
$stmt->execute([$user_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['data' => $events]);
?>
