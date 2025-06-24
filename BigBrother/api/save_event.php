
<?php
include('../includes/auth.php');
include('../includes/db.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['event_name'] ?? '';
    $start = $_POST['event_start_date'] ?? '';
    $end = $_POST['event_end_date'] ?? '';

    if ($name && $start && $end) {
        $stmt = $pdo->prepare("INSERT INTO calendar_event_master (user_id, event_name, event_start_date, event_end_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $start, $end]);
        echo json_encode(['status' => true, 'msg' => 'Event saved']);
    } else {
        echo json_encode(['status' => false, 'msg' => 'Missing data']);
    }
}

?>