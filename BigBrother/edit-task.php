<?php
include('includes/auth.php');  // Check login
include('includes/db.php');

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$task_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch task data
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch();

if (!$task) {
    // Task not found or not owned by user
    header('Location: dashboard.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $deadline = $_POST['deadline'] ?? '';

    if ($title && $deadline) {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, deadline = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $deadline, $task_id, $user_id]);
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Please fill in all required fields.";
    }
}

include('includes/header.php');
include('includes/nav.php');
?>

<div class="container mt-5">
    <h2>Edit Task</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="<?= htmlspecialchars($task['title']) ?>"
                required
            >
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input
                type="date"
                id="deadline"
                name="deadline"
                class="form-control"
                value="<?= htmlspecialchars($task['deadline']) ?>"
                required
            >
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="dashboard.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php include('includes/footer.php'); ?>
