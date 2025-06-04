<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include('../includes/db.php');

// Handle user deletion
if (isset($_POST['delete']) && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);
    if ($userId !== $_SESSION['user_id']) { // Prevent self-deletion
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);
    }
}

// Handle password change
if (isset($_POST['change_password']) && isset($_POST['user_id']) && isset($_POST['new_password'])) {
    $userId = intval($_POST['user_id']);
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$newPassword, $userId]);
}

// Fetch users
$users = $pdo->query("
    SELECT id, username, streak, name, surname, birthday, email, gender, education, role
    FROM users
    ORDER BY id ASC
")->fetchAll();

include('../includes/header.php');
include('../includes/nav.php');
?>

<div class="container mt-5">
    <h2>Manage Users</h2>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Streak</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Birthday</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Education</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['streak']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['surname']) ?></td>
                        <td><?= htmlspecialchars($user['birthday']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['gender']) ?></td>
                        <td><?= htmlspecialchars($user['education']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <!-- Delete User -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm mb-1"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                            <br>
                            <!-- Change Password -->
                            <form method="POST" class="d-inline-flex ms-2" style="gap: 5px;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <input type="password" name="new_password" placeholder="New Password" required class="form-control form-control-sm" style="width:150px;">
                                <button type="submit" name="change_password" class="btn btn-warning btn-sm">Change</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
