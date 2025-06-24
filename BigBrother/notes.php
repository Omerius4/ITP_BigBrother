<?php
include('includes/auth.php');
include('includes/db.php');

// Get subject_id from URL
if (!isset($_GET['subject_id']) || !is_numeric($_GET['subject_id'])) {
    die("Subject ID is missing or invalid.");
}
$subject_id = (int)$_GET['subject_id'];
$user_id = $_SESSION['user_id'];

// Get subject name
$stmt = $pdo->prepare("SELECT name FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $user_id]);
$subject = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$subject) {
    die("Subject not found.");
}
$subject_name = $subject['name'];


// Pre-fill data if editing
$note_to_edit = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['edit'], $user_id]);
    $note_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle note submission (add or update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $note_id = $_POST['note_id'] ?? null;
    $img_path = '';

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $img_path = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $img_path);
    }

    if ($note_id) {
        // UPDATE note
        if ($img_path) {
            $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, image_path = ?, subject_id = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$title, $content, $img_path, $subject_id, $note_id, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, subject_id = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$title, $content, $subject_id, $note_id, $user_id]);
        }
    } else {
        // INSERT note
        $stmt = $pdo->prepare("INSERT INTO notes (user_id, subject_id, title, content, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $subject_id, $title, $content, $img_path]);
    }

    // Redirect to clear POST data
    header("Location: notes.php?subject_id=" . $subject_id);
    exit();
}

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['delete'], $user_id]);

    header("Location: notes.php?subject_id=" . $subject_id);
    exit();
}

include('includes/header.php');
include('includes/nav.php');
?>

<div class="container mt-5">
    <h2 class="mb-4">📝 Your Notes for Subject <?= htmlspecialchars($subject_name) ?></h2>

    <!-- Note Form -->
    <form method="POST" enctype="multipart/form-data" class="mb-5 p-4 bg-light rounded shadow-sm">
        <input type="hidden" name="note_id" value="<?= $note_to_edit['id'] ?? '' ?>">
        <input type="hidden" name="subject_id" value="<?= $subject_id ?>">

        <div class="mb-3">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="title" name="title" required value="<?= htmlspecialchars($note_to_edit['title'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4"><?= htmlspecialchars($note_to_edit['content'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (optional)</label>
            <input class="form-control" type="file" name="image" id="image">
        </div>

        <button type="submit" class="btn btn-success">Save Note</button>
        <a href="/BigBrother/api/subjects.php" class="btn btn-secondary">Back to Subjects</a>
    </form>

    <!-- Notes Display -->
    <div class="row">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id = ? AND subject_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id, $subject_id]);

        foreach ($stmt as $note):
        ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($note['title']) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $note['created_at'] ?></h6>
                        <p class="card-text"><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                        <?php if ($note['image_path']): ?>
                            <img src="<?= $note['image_path'] ?>" onclick="openImage(this.src)" class="img-fluid rounded mt-2" style="cursor: zoom-in;">
                        <?php endif; ?>
                        <hr>
                        <a href="?subject_id=<?= $subject_id ?>&edit=<?= $note['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?subject_id=<?= $subject_id ?>&delete=<?= $note['id'] ?>" onclick="return confirm('Delete this note?')" class="btn btn-sm btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Image Modal -->
<div id="imgModal" onclick="this.style.display='none'" style="display:none; position:fixed; top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8); justify-content:center; align-items:center;">
    <img id="fullImg" style="max-width: 90%; max-height: 90%;">
</div>

<script>
function openImage(src) {
    document.getElementById('fullImg').src = src;
    document.getElementById('imgModal').style.display = 'flex';
}
</script>

<?php include('includes/footer.php'); ?>
