<?php
session_start();
include('../includes/db.php'); 

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    exit('Invalid request');
}

if (isset($_POST['add'])) {
    $title = trim($_POST['title'] ?? '');
    $deadline = $_POST['deadline'] ?? '';

    if ($title && $deadline) {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, deadline) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $title, $deadline]);
    }
} elseif (isset($_POST['toggle'])) {
    $task_id = (int)($_POST['task_id'] ?? 0);
    $stmt = $pdo->prepare("SELECT is_completed FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$task_id, $user_id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($task) {
        $newStatus = $task['is_completed'] ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE tasks SET is_completed = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$newStatus, $task_id, $user_id]);
    }
} elseif (isset($_POST['delete'])) {
    $task_id = (int)($_POST['task_id'] ?? 0);
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$task_id, $user_id]);
} else {
    exit('Invalid action');
}

header('Location: ../dashboard.php');
exit;
