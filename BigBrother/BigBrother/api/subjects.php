<?php
include('../includes/auth.php');
include('../includes/db.php');

$user_id = $_SESSION['user_id'];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle'], $_POST['subject_id'])) {
        $subject_id = (int)$_POST['subject_id'];
        $stmt = $pdo->prepare("UPDATE subjects SET is_completed = NOT is_completed WHERE id = ? AND user_id = ?");
        $stmt->execute([$subject_id, $user_id]);
        header('Location: subjects.php');
        exit;
    }

    if (isset($_POST['delete'], $_POST['subject_id'])) {
        $subject_id = (int)$_POST['subject_id'];
        $stmt = $pdo->prepare("DELETE FROM subjects WHERE id = ? AND user_id = ?");
        $stmt->execute([$subject_id, $user_id]);
        header('Location: subjects.php');
        exit;
    }

    if (isset($_POST['add'], $_POST['name'], $_POST['ects'])) {
        $name = trim($_POST['name']);
        $ects = (int)$_POST['ects'];
        if ($name !== '' && $ects > 0) {
            $stmt = $pdo->prepare("INSERT INTO subjects (user_id, name, ects, is_completed) VALUES (?, ?, ?, 0)");
            $stmt->execute([$user_id, $name, $ects]);
        }
        header('Location: subjects.php');
        exit;
    }

    header('Location: subjects.php');
    exit;
}

// GET: Display page
include('../includes/header.php');
include('../includes/nav.php');
?>

<div class="container py-4">
    <h1 class="mb-4 text-center">📚 Subjects</h1>

    <!-- Add Subject Form -->
    <form class="row g-3 mb-4 justify-content-center" method="POST" action="subjects.php">
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

    <!-- Subjects Table (Responsive Wrapper) -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th>Status</th>
                    <th>Name</th>
                    <th>ECTS</th>
                    <th style="min-width: 280px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ?");
            $stmt->execute([$user_id]);

            foreach ($stmt as $subj):
            ?>
                <tr>
                    <td>
                        <form method="POST" action="subjects.php" class="d-inline">
                            <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                            <button type="submit" name="toggle" class="btn btn-sm <?= $subj['is_completed'] ? 'btn-success' : 'btn-secondary' ?>">
                                <?= $subj['is_completed'] ? "✅ Completed" : "❌ Incomplete" ?>
                            </button>
                        </form>
                    </td>

                    <td><?= htmlspecialchars($subj['name']) ?></td>
                    <td><?= (int)$subj['ects'] ?></td>

                    <td>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <a href="../notes.php?subject_id=<?= $subj['id'] ?>" class="btn btn-primary btn-sm">Add Notes</a>
                            <a href="/BigBrother/edit-subject.php?id=<?= $subj['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="subjects.php" onsubmit="return confirm('Delete this subject?');" class="d-inline">
                                <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <button type="button" class="btn btn-info btn-sm toggle-notes-btn" data-subject-id="<?= $subj['id'] ?>">
                                Show Notes
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Hidden notes row -->
                <tr class="notes-row" id="notes-row-<?= $subj['id'] ?>" style="display: none;">
                    <td colspan="4">
                        <?php
                        $stmtNotes = $pdo->prepare("SELECT * FROM notes WHERE subject_id = ? AND user_id = ?");
                        $stmtNotes->execute([$subj['id'], $user_id]);
                        $notes = $stmtNotes->fetchAll(PDO::FETCH_ASSOC);

                        if (count($notes) === 0) {
                            echo "<em>No notes found for this subject.</em>";
                        } else {
                            echo "<ul class='list-group'>";
                            foreach ($notes as $note) {
                                echo "<li class='list-group-item'>";
                                echo "<strong>" . htmlspecialchars($note['title']) . "</strong>: ";
                                echo nl2br(htmlspecialchars($note['content']));
                                echo "</li>";
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
        const subjectId = button.getAttribute('data-subject-id');
        const row = document.getElementById(`notes-row-${subjectId}`);
        if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'table-row';
            button.textContent = "Hide Notes";
        } else {
            row.style.display = 'none';
            button.textContent = "Show Notes";
        }
    });
});
</script>

<?php include('../includes/footer.php'); ?>
