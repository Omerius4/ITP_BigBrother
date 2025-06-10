<?php
session_start();
include('../includes/db.php');

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) exit;

if (isset($_POST['add'])) {
    $date = $_POST['date'];
    $level = (int)$_POST['stress_level'];
    $stmt = $pdo->prepare("INSERT INTO stress_levels (user_id, stress_level, date) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE stress_level = VALUES(stress_level)");
    $stmt->execute([$user_id, $level, $date]);
    header('Location: ../dashboard.php');
    exit;
}

// Für AJAX-Requests (Diagramm-Daten)
if (isset($_GET['view'])) {
    $view = $_GET['view'];
    if ($view === 'daily') {
        $stmt = $pdo->prepare("SELECT date, stress_level FROM stress_levels WHERE user_id = ? ORDER BY date ASC");
        $stmt->execute([$user_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    } elseif ($view === 'weekly') {
        $stmt = $pdo->prepare("SELECT YEAR(date) as y, WEEK(date,1) as w, AVG(stress_level) as avg_stress FROM stress_levels WHERE user_id = ? GROUP BY y, w ORDER BY y, w");
        $stmt->execute([$user_id]);
        $data = [];
        foreach ($stmt as $row) {
            $data[] = [
                'label' => $row['y'] . '-KW' . $row['w'],
                'avg_stress' => round($row['avg_stress'], 2)
            ];
        }
        echo json_encode($data);
    } elseif ($view === 'monthly') {
        $stmt = $pdo->prepare("SELECT YEAR(date) as y, MONTH(date) as m, AVG(stress_level) as avg_stress FROM stress_levels WHERE user_id = ? GROUP BY y, m ORDER BY y, m");
        $stmt->execute([$user_id]);
        $data = [];
        foreach ($stmt as $row) {
            $data[] = [
                'label' => $row['y'] . '-' . str_pad($row['m'], 2, '0', STR_PAD_LEFT),
                'avg_stress' => round($row['avg_stress'], 2)
            ];
        }
        echo json_encode($data);
    }
    exit;
}