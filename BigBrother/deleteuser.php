<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit();
}

include_once "includes/db.php";

$username = $_SESSION["username"];

// Get user ID
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['id'];
    // Delete related notes
    $stmt = $pdo->prepare("DELETE FROM notes WHERE user_id = ?");
    $stmt->execute([$user_id]);
    // Delete the user
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
}

// Destroy session
session_unset();
session_destroy();

header("Location: login.php");
exit();
?>