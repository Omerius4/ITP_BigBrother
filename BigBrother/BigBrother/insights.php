<?php include('includes/auth.php'); ?>
<?php 
include('includes/db.php'); 
include('includes/header.php'); 
include('includes/nav.php');
?>

<div class="container mt-6">
<h1>Your Insights</h1>

<?php
// Hours studied
$stmt = $pdo->prepare("SELECT SUM(duration_minutes) FROM study_sessions WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_minutes = $stmt->fetchColumn();
echo "<p>Total Study Time: " . round($total_minutes / 60, 2) . " hours</p>";

// Tasks completed
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = ? AND is_completed = 1");
$stmt->execute([$_SESSION['user_id']]);
echo "<p>Tasks Completed: " . $stmt->fetchColumn() . "</p>";
?>

<div class="container mt-5">
<h2>Latest News</h2>
<div class="row"> 
<?php
$news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
foreach ($news as $item):
?>
    <div class="col-md-4 d-flex">
        <div class="card mb-4 flex-fill">
            <?php if (!empty($item['image_path'])): ?>
                <img src="<?= htmlspecialchars($item['image_path']) ?>"
                     class="card-img-top"
                     style="width: 100%; height: 150px; object-fit: cover;"
                     alt="News Image">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars(substr($item['content'], 0, 120))) ?>...</p>
                <a href="news.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-primary">Read More</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

</div>
</div>

<?php
include('includes/footer.php');
?>

