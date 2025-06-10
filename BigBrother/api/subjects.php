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

    // If none of the actions matched, just redirect
    header('Location: subjects.php');
    exit;
}

// GET request: show the page
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

    <!-- Subjects Table -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>ECTS</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ?");
        $stmt->execute([$user_id]);

        foreach ($stmt as $subj):
        ?>
            <tr>
                <!-- Status toggle -->
                <td>
                    <form method="POST" action="/BigBrother/api/subjects.php" style="display:inline;">
                        <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                        <button type="submit" name="toggle" class="btn btn-sm <?= $subj['is_completed'] ? 'btn-success' : 'btn-secondary' ?>">
                            <?= $subj['is_completed'] ? "✅ Completed" : "❌ Incomplete" ?>
                        </button>
                    </form>
                </td>

                <!-- Name -->
                <td><?= htmlspecialchars($subj['name']) ?></td>

                <!-- ECTS -->
                <td><?= (int)$subj['ects'] ?></td>

                <!-- Actions -->
                <td class="d-flex gap-2 align-items-center">
                    <a href="../notes.php?subject_id=<?= $subj['id'] ?>" class="btn btn-primary btn-sm">Add Notes</a>
                    <a href="/BigBrother/edit-subject.php?id=<?= $subj['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" action="subjects.php" onsubmit="return confirm('Delete this subject?');" style="margin:0;">
                        <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                    </form>

                    <!-- Toggle Notes Button -->
                    <button type="button" class="btn btn-brand btn-sm toggle-notes-btn" data-subject-id="<?= $subj['id'] ?>">
                        Notes for this Subject
                    </button>
                </td>
            </tr>

            <!-- Hidden notes row -->
            <tr class="notes-row" id="notes-row-<?= $subj['id'] ?>" style="display:none;">
                <td colspan="4">
                    <?php
                    // Fetch notes for this subject
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

<script>
document.querySelectorAll('.toggle-notes-btn').forEach(button => {
    button.addEventListener('click', () => {
        const subjectId = button.getAttribute('data-subject-id');
        const notesRow = document.getElementById(`notes-row-${subjectId}`);
        if (notesRow.style.display === 'none' || notesRow.style.display === '') {
            notesRow.style.display = 'table-row';
        } else {
            notesRow.style.display = 'none';
        }
    });
});
</script>

<?php include('../includes/footer.php'); ?>
