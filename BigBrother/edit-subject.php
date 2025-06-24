<?php

include('includes/auth.php');
include('includes/db.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$subject_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch subject for editing
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $user_id]);
$subject = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$subject) {
    header("Location: dashboard.php");
    exit();
}

// Handle subject update (name/ects)
if (isset($_POST['update_subject'])) {
    $name = trim($_POST['name']);
    $ects = (int)$_POST['ects'];
    if ($name !== '' && $ects > 0) {
        $update = $pdo->prepare("UPDATE subjects SET name = ?, ects = ? WHERE id = ? AND user_id = ?");
        $update->execute([$name, $ects, $subject_id, $user_id]);
        header("Location: edit-subject.php?id=" . $subject_id);
        exit();
    }
}

// Handle new grade submission
if (isset($_POST['add_grade']) && isset($_POST['grade'])) {
    $grade = floatval($_POST['grade']);
    if ($grade >= 1 && $grade <= 6) {
        $stmt = $pdo->prepare("INSERT INTO subject_grades (subject_id, user_id, grade) VALUES (?, ?, ?)");
        $stmt->execute([$subject_id, $user_id, $grade]);
        header("Location: edit-subject.php?id=" . $subject_id);
        exit();
    }
}

// Handle grade delete
if (isset($_POST['delete_grade']) && isset($_POST['grade_id'])) {
    $grade_id = (int)$_POST['grade_id'];
    $stmt = $pdo->prepare("DELETE FROM subject_grades WHERE id = ? AND subject_id = ? AND user_id = ?");
    $stmt->execute([$grade_id, $subject_id, $user_id]);
    header("Location: edit-subject.php?id=" . $subject_id);
    exit();
}

// Fetch all grades for this subject
$stmt = $pdo->prepare("SELECT * FROM subject_grades WHERE subject_id = ? AND user_id = ? ORDER BY created_at DESC");
$stmt->execute([$subject_id, $user_id]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate average
$avg = null;
if ($grades) {
    $sum = 0;
    foreach ($grades as $g) $sum += $g['grade'];
    $avg = $sum / count($grades);
}

include "includes/header.php";
include "includes/nav.php";
?>

<div class="container mt-5" style="background-color:white; border-radius:10px; padding:25px;">
    <h2>Edit Subject</h2>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="name" class="form-label">Subject Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($subject['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="ects" class="form-label">ECTS</label>
            <input type="number" class="form-control" id="ects" name="ects" value="<?= (int)$subject['ects'] ?>" required>
        </div>
        <button type="submit" name="update_subject" class="btn btn-success">Save Changes</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>

    <h4>Grades</h4>
    <form method="POST" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="number" step="0.01" min="1" max="6" class="form-control" name="grade" placeholder="Add grade" required>
        </div>
        <div class="col-auto">
            <button type="submit" name="add_grade" class="btn btn-primary">Add Grade</button>
        </div>
    </form>

    <?php if ($grades): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Grade</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $g): ?>
                    <tr>
                        <td><?= htmlspecialchars($g['grade']) ?></td>
                        <td><?= htmlspecialchars($g['created_at']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="grade_id" value="<?= $g['id'] ?>">
                                <button type="submit" name="delete_grade" class="btn btn-danger btn-sm" onclick="return confirm('Delete this grade?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-info fw-bold">
                    <td colspan="3">Ø Durchschnitt: <?= number_format($avg, 2) ?></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No grades entered yet.</div>
    <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>