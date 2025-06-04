<?php include('includes/auth.php'); ?>
<?php include('includes/db.php'); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/nav.php'); ?>

<div class="mb-5">
    <h1 class="display-5 fw-bold text-center mt-4">Productivity Dashboard</h1>
    <p class="text-center">Track your tasks, manage your time, and boost your productivity!</p> 

    <h2 class="mb-3 mt-4 ms-1 text-center">⏳ Pomodoro Timer</h2>
        <div id="pomodoro">
            <div id="status">Ready to work</div>
            <div id="timer">25:00</div>
            <button id="startBtn" onclick="startPomodoro()" class="btn btn-brand">Start</button>
            <div id="cycle">Cycle: 0 / 4</div>
        </div>

<script src="asset/pomodoro.js"></script>

</div>

<!-- To-Do List Section -->
    <div class="mb-5">
        <h2 class="mb-3 mt-4 ms-1 text-center">📝 Your To-Do List</h2>
        <form class="row g-3 mb-4 mt-2 ms-1" method="POST" action="api/tasks.php">
            <div class="col-md-4">
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>
            <div class="col-md-3">
                <input type="date" name="deadline" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add" class="btn btn-primary w-100">Add Task</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $task['id'] ?>">
                                ✏️ Edit
                            </button>

                            <!-- Delete Button -->
                            <form method="POST" action="api/tasks.php" onsubmit="return confirm('Delete this task?')">
                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-sm btn-danger">🗑️</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $task['id'] ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <form class="modal-content" style="background-color: white;" method="POST" action="api/tasks.php">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?= $task['id'] ?>">Edit Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deadline</label>
                                    <input type="date" name="deadline" class="form-control" value="<?= $task['deadline'] ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                      </div>
                    </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>