<?php
include('../includes/auth.php');
include('../includes/db.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php"  || "Location: edit-subject.php?id=". $subject_id);
    exit();
}

$subject_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch subject for editing
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $user_id]);
$subject = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$subject) {
    header("Location: dashboard.php" || "Location: edit-subject.php?id=". $subject_id);
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $ects = (int)$_POST['ects'];

    if ($name !== '' && $ects > 0) {
        $update = $pdo->prepare("UPDATE subjects SET name = ?, ects = ? WHERE id = ? AND user_id = ?");
        $update->execute([$name, $ects, $subject_id, $user_id]);

        header("Location: dashboard.php" || "Location: edit-subject.php?id=". $subject_id);
        exit();
    }
}
?>

<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>

<div class="container mt-5" style="background-color:white; border-radius:10px; padding:25px;">
    <h2>Edit Subject</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Subject Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($subject['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="ects" class="form-label">ECTS</label>
            <input type="number" class="form-control" id="ects" name="ects" value="<?= (int)$subject['ects'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include "includes/footer.php"; ?>
