
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include('../includes/db.php');

$stmt = $pdo->query("SELECT * FROM help ORDER BY submitted_at DESC");
$help = $stmt->fetchAll();

include('../includes/header.php');
include('../includes/nav.php');
?>

<div class="container mt-5">
    <h2>User Complaints</h2>
    <?php if (empty($help)): ?>
        <p>No complaints submitted yet.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($help as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['user_id']) ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($c['message'])) ?></td>
                        <td><?= $c['submitted_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
