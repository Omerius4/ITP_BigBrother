<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include('../includes/db.php');

$editing = false;

// Handle delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: news.php");
    exit();
}

// Handle fetch for editing
if (isset($_GET['edit'])) {
    $editing = true;
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editNews = $stmt->fetch();
    if (!$editNews) {
        header("Location: news.php");
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $imagePath = $_POST['existing_image'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../uploads/';
        $filename = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . time() . '_' . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = str_replace('../', '', $targetPath);
        }
    }

    if ($title && $content) {
        if (isset($_POST['news_id'])) {
            // Update existing news
            $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$title, $content, $imagePath, $_POST['news_id']]);
            $success = "News updated successfully.";
        } else {
            // Create new news
            $stmt = $pdo->prepare("INSERT INTO news (title, content, image_path) VALUES (?, ?, ?)");
            $stmt->execute([$title, $content, $imagePath]);
            $success = "News posted successfully.";
        }
    } else {
        $error = "Title and content are required.";
    }
}

// Fetch all news
$allNews = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/nav.php'); ?>

<div class="container mt-5">
    <h2><?= $editing ? 'Edit News' : 'Post News' ?></h2>
    <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <?php if ($editing): ?>
            <input type="hidden" name="news_id" value="<?= $editNews['id'] ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editNews['image_path']) ?>">
        <?php endif; ?>
        <input type="text" name="title" class="form-control mb-2" placeholder="Title" required value="<?= $editing ? htmlspecialchars($editNews['title']) : '' ?>">
        <textarea name="content" class="form-control mb-2" rows="5" placeholder="Write your news..." required><?= $editing ? htmlspecialchars($editNews['content']) : '' ?></textarea>
        <input type="file" name="image" class="form-control mb-2">
        <?php if ($editing && $editNews['image_path']): ?>
            <p>Current image:</p>
            <img src="../<?= htmlspecialchars($editNews['image_path']) ?>" width="150" class="mb-2">
        <?php endif; ?>
        <br><button class="btn btn-brand"><?= $editing ? 'Update' : 'Publish' ?> News</button>
        <?php if ($editing): ?>
            <a href="news.php" class="btn btn-white ms-2">Cancel</a>
        <?php endif; ?>
    </form>

    <hr>

    <h3>All News</h3>
    <?php if (empty($allNews)): ?>
        <p>No news posted yet.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allNews as $news): ?>
                    <tr>
                        <td><?= htmlspecialchars($news['title']) ?></td>
                        <td><?= $news['created_at'] ?></td>
                        <td>
                            <a href="?edit=<?= $news['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?= $news['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this news item?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
