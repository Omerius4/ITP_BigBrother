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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $education = $_POST['education'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    $update = $pdo->prepare("UPDATE users SET name = ?, surname = ?, birthday = ?, email = ?, gender = ?, education = ?, password = ? WHERE username = ?");
    $update->execute([$name, $surname, $birthday, $email, $gender, $education, $password, $username]);

    header("Location: profile.php");
    exit();
}
?>

<?php 
include "includes/header.php"; 
include "includes/nav.php"; 
?>
<div class="container mt-5" style="background-color: white; border-radius: 15px; padding: 25px;">
    <h2>Edit Profile</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Surname</label>
            <input type="text" name="surname" class="form-control" value="<?= htmlspecialchars($user['surname']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Birthday</label>
            <input type="date" name="birthday" class="form-control" value="<?= htmlspecialchars($user['birthday']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $user['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Education</label>
            <select name="education" class="form-control" required>
                <option value="Middle School" <?= $user['education'] == 'Middle School' ? 'selected' : '' ?>>Middle School</option>
                <option value="High School" <?= $user['education'] == 'High School' ? 'selected' : '' ?>>High School</option>
                <option value="Undergraduate" <?= $user['education'] == 'Undergraduate' ? 'selected' : '' ?>>Undergraduate</option>
                <option value="Masters" <?= $user['education'] == 'Masters' ? 'selected' : '' ?>>Masters</option>
            </select>
        </div>
        <div class="mb-3">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-success" type="submit">Save Changes</button>
    </form>
</div>
<?php include "includes/footer.php"; ?>