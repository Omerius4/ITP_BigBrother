<?php
session_start();
include('includes/db.php');
include('includes/header.php');
include('includes/nav.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid news ID.</p>";
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    echo "<p>News article not found.</p>";
    exit;
}
?>

<div class="container mt-5">
    <h2><?= htmlspecialchars($news['title']) ?></h2>
    <p><small class="text-muted"><?= $news['created_at'] ?></small></p>
    <?php if (!empty($news['image_path'])): ?>
        <img src="<?= htmlspecialchars($news['image_path']) ?>" class="img-fluid" mb-3 style="max-width: 300px; height: auto;" alt="News Image">
    <?php endif; ?>
    <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
    <a href="insights.php" class="btn btn-secondary mt-3 mb-4">← Back to Insights</a>
</div>

<?php include('includes/footer.php'); ?>
