<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users 
        (username, password, name, surname, birthday, email, gender, education) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $_POST['username'],
        $hashed,
        $_POST['name'],
        $_POST['surname'],
        $_POST['birthday'],
        $_POST['email'],
        $_POST['gender'],
        $_POST['education']
    ]);

    header("Location: login.php");
}
?>

<?php
include('includes/header.php');
include('includes/nav.php');
?>

<div class="container mt-5">
<form method="POST">
    <h2>Register</h2>
    
    <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
    </div>
    <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="First Name" required>
    </div>
    <div class="mb-3">
        <input type="text" name="surname" class="form-control" placeholder="Last Name" required>
    </div>
    <div class="mb-3">
        <input type="date" name="birthday" class="form-control" required>
    </div>
    <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Gender:</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Male" required>
            <label class="form-check-label">Male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Female" required>
            <label class="form-check-label">Female</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Other" required>
            <label class="form-check-label">Other</label>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Education:</label>
        <select name="education" class="form-select" required>
            <option value="">-- Select --</option>
            <option value="Middle School">Middle School</option>
            <option value="High School">High School</option>
            <option value="Undergraduate">Undergraduate</option>
            <option value="Masters">Masters</option>
        </select>
    </div>

    <button type="submit" class="btn btn-brand mb-4">Register</button>
</form>
</div>

<?php
include('includes/footer.php');
?>