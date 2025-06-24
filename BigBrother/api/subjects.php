<?php
include('../includes/auth.php');
include('../includes/db.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle'], $_POST['subject_id'])) {
        $subject_id = (int)$_POST['subject_id'];
        $pdo->prepare("UPDATE subjects SET is_completed = NOT is_completed WHERE id = ? AND user_id = ?")
            ->execute([$subject_id, $user_id]);
        header('Location: subjects.php');
        exit;
    }

    if (isset($_POST['delete'], $_POST['subject_id'])) {
        $subject_id = (int)$_POST['subject_id'];
        $pdo->prepare("DELETE FROM subjects WHERE id = ? AND user_id = ?")
            ->execute([$subject_id, $user_id]);
        header('Location: subjects.php');
        exit;
    }

    if (isset($_POST['add'], $_POST['name'], $_POST['ects'])) {
        $name = trim($_POST['name']);
        $ects = (int)$_POST['ects'];
        if ($name && $ects > 0) {
            $pdo->prepare("INSERT INTO subjects (user_id, name, ects, is_completed) VALUES (?, ?, ?, 0)")
                ->execute([$user_id, $name, $ects]);
        }
        header('Location: subjects.php');
        exit;
    }

    // ✅ Fixed: use submit_grade instead of grade to avoid name conflict
    if (isset($_POST['submit_grade'], $_POST['subject_id'], $_POST['grade'])) {
        $subject_id = (int)$_POST['subject_id'];
        $grade = (float)$_POST['grade'];
        $pdo->prepare("INSERT INTO subject_grades (subject_id, user_id, grade) VALUES (?, ?, ?)")
            ->execute([$subject_id, $user_id, $grade]);
        header('Location: subjects.php');
        exit;
    }
}

include('../includes/header.php');
include('../includes/nav.php');
?>

<div class="container py-4">
    <h1 class="mb-4 text-center">📚 Subjects</h1>

    <!-- Add Subject -->
    <form class="row g-3 mb-4 justify-content-center" method="POST">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="Subject Name" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="ects" class="form-control" placeholder="ECTS" required>
        </div>
        <div class="col-md-2">
            <button type="submit" name="add" class="btn btn-success w-100">Add Subject</button>
        </div>
    </form>

    <!-- Subject Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th>Status</th>
                    <th>Name</th>
                    <th>ECTS</th>
                    <th>Average Grade</th>
                    <th style="min-width: 300px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ?");
            $stmt->execute([$user_id]);

            foreach ($stmt as $subj):
                $subj_id = $subj['id'];
                $avg_stmt = $pdo->prepare("SELECT AVG(grade) AS avg_grade FROM subject_grades WHERE subject_id = ? AND user_id = ?");
                $avg_stmt->execute([$subj_id, $user_id]);
                $avg = $avg_stmt->fetch(PDO::FETCH_ASSOC)['avg_grade'];
            ?>
                <tr>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="subject_id" value="<?= $subj_id ?>">
                            <button type="submit" name="toggle" class="btn btn-sm <?= $subj['is_completed'] ? 'btn-success' : 'btn-secondary' ?>">
                                <?= $subj['is_completed'] ? "✅ Completed" : "❌ Incomplete" ?>
                            </button>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($subj['name']) ?></td>
                    <td><?= (int)$subj['ects'] ?></td>
                    <td><?= $avg !== null ? number_format($avg, 2) : '—' ?></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <div class="d-flex flex-row gap-2 w-200">
                                <a href="../notes.php?subject_id=<?= $subj_id ?>" class="btn btn-primary btn-sm w-40">Add Notes</a>
                                <button type="button" class="btn btn-info btn-sm w-40 toggle-notes-btn" data-subject-id="<?= $subj_id ?>">Show Notes</button>
                                <a href="/BigBrother/edit-subject.php?id=<?= $subj_id ?>" class="btn btn-warning btn-sm w-40">Edit</a>
                                <form method="POST" onsubmit="return confirm('Delete this subject?');" class="w-40">
                                    <input type="hidden" name="subject_id" value="<?= $subj_id ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm w-100">Delete</button>
                                </form>
                                <!-- ✅ Fixed: renamed button to submit_grade -->
                                <form method="POST" class="w-40 mt-2 d-flex gap-2">
                                    <input type="hidden" name="subject_id" value="<?= $subj_id ?>">
                                    <input type="number" step="0.01" name="grade" class="form-control form-control-sm" placeholder="Enter Grade" required>
                                    <button type="submit" class="btn btn-sm btn-outline-success" name="submit_grade">Add Grade</button>
                                </form>
                        </div>
                        </div>
                    </td>
                </tr>

                <!-- Hidden Notes Row -->
                <tr class="notes-row" id="notes-row-<?= $subj_id ?>" style="display: none;">
                    <td colspan="5">
                        <?php
                        $notes_stmt = $pdo->prepare("SELECT * FROM notes WHERE subject_id = ? AND user_id = ?");
                        $notes_stmt->execute([$subj_id, $user_id]);
                        $notes = $notes_stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (empty($notes)) {
                            echo "<em>No notes found for this subject.</em>";
                        } else {
                            echo "<ul class='list-group'>";
                            foreach ($notes as $note) {
                                echo "<li class='list-group-item'><strong>" . htmlspecialchars($note['title']) . "</strong>: " . nl2br(htmlspecialchars($note['content'])) . "</li>";
                            }
                            echo "</ul>";
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-notes-btn').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.dataset.subjectId;
        const row = document.getElementById(`notes-row-${id}`);
        const isVisible = row.style.display === 'table-row';
        row.style.display = isVisible ? 'none' : 'table-row';
        button.textContent = isVisible ? 'Show Notes' : 'Hide Notes';
    });
});
</script>

<?php include('../includes/footer.php'); ?>
