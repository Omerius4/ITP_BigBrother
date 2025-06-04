<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $user_id = $_SESSION['user_id'] ?? null;

    if ($name && $email && $message) {
        $stmt = $pdo->prepare("INSERT INTO help (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $email, $subject, $message]);
        $success = "Your complaint has been submitted.";
    } else {
        $error = "All fields are required.";
    }
}

include('includes/header.php');
include('includes/nav.php');
?>

<!-- CONTACT -->
    <section class="section-padding bg-light" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 text-white fw-semibold">Get in touch</h1>
                        <div class="line bg-white"></div>
                        <p class="text-white">Your user experience is just as important to us! If you see any room for improvement, make sure to let us know!</p>
                    </div>
                </div>
            </div>
            <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <div class="row justify-content-center" data-aos="fade-down" data-aos-delay="250">
                <div class="col-lg-8">
                    <form method="POST" action="" class="row g-3 p-lg-5 p-4 bg-white theme-shadow">
                        <div class="form-group col-lg-12">
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="email" name="email" class="form-control" placeholder="Enter Email address" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="text" name="subject" class="form-control" placeholder="Enter subject">
                        </div>
                        <div class="form-group col-lg-12">
                            <textarea name="message" rows="5" class="form-control" placeholder="Enter Message"></textarea>
                        </div>
                        <div class="form-group col-lg-12 d-grid">
                            <button class="btn btn-brand">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php include('includes/footer.php'); ?>
