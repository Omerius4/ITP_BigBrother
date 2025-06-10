<?php
include('includes/auth.php');
include('includes/db.php');
include('includes/header.php');
include('includes/nav.php');
?>

<body data-bs-spy="scroll" data-bs-target=".navbar">
<div class="container mt-5">

    <!-- Dashboard Title -->
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold">Dashboard</h1>
        <?php
        $stmt = $pdo->prepare("SELECT streak FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $streak = $stmt->fetchColumn();
        echo "<p class='lead'>🔥 Streak: <strong>$streak</strong></p>";
        ?>
    </div>

    <!-- Main Row -->
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <h2 class="mb-3 text-center">📝 To-Do List</h2>
            <form class="row g-3 mb-4 justify-content-center" method="POST" action="api/tasks.php">
                <div class="col-md-6">
                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="col-md-4">
                    <input type="date" name="deadline" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="add" class="btn btn-primary w-100">Add</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Status</th>
                            <th>Title</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        foreach ($stmt as $task):
                        ?>
                        <tr>
                            <td>
                                <form method="POST" action="api/tasks.php">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <button type="submit" name="toggle" class="btn btn-sm btn-outline-secondary"><?= $task['is_completed'] ? "✅" : "❌" ?></button>
                                </form>
                            </td>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['deadline']) ?></td>
                            <td class="d-flex justify-content-center gap-2">
                                <!-- Changed Edit button to link -->
                                <a href="edit-task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>

                                <form method="POST" action="api/tasks.php" onsubmit="return confirm('Delete this task?')">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-sm btn-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Subjects -->
        <div class="col-md-6 mb-4">
            <h2 class="mb-3 text-center">📚 Subjects</h2>
            <form class="row g-3 mb-4 justify-content-center" method="POST" action="dashboard.php">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Subject Name" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="ects" class="form-control" placeholder="ECTS" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="add" class="btn btn-success w-100">Add</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Name</th>
                            <th>ECTS</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        foreach ($stmt as $subj):
                        ?>
                        <tr>
                            <td>
                                <form method="POST" action="api/subjects.php">
                                    <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                                    <button type="submit" name="toggle" class="btn btn-sm <?= $subj['is_completed'] ? 'btn-success' : 'btn-secondary' ?>">
                                        <?= $subj['is_completed'] ? "✅ Completed" : "❌ Incomplete" ?>
                                    </button>
                                </form>
                            </td>
                            <td><?= htmlspecialchars($subj['name']) ?></td>
                            <td><?= (int)$subj['ects'] ?></td>
                            <td class="d-flex gap-2">
                                <a href="notes.php?subject_id=<?= $subj['id'] ?>" class="btn btn-primary btn-sm">Add Notes</a>
                                <a href="edit-subject.php?id=<?= $subj['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form method="POST" action="api/subjects.php" onsubmit="return confirm('Delete this subject?');">
                                    <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
