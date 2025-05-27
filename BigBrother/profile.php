<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit();
}

include_once "includes/db.php";
$username = $_SESSION["username"];
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>



<?php 
include "includes/header.php";
include "includes/nav.php"; 
?>

<div class="container mt-5" style="background-color: white; border-radius: 15px; padding: 25px;">
    <h2>Your Profile</h2>
    <hr>
    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></p>
    <p><strong>Surname:</strong> <?= htmlspecialchars($user['surname']); ?></p>
    <p><strong>Birthday:</strong> <?= htmlspecialchars($user['birthday']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']); ?></p>
    <p><strong>Education:</strong> <?= htmlspecialchars($user['education']); ?></p>

    <a href="edit-user.php" class="btn btn-outline-success">Edit Profile</a>
    <a href="deleteUser.php" class="btn btn-outline-danger float-end" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a>
</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
