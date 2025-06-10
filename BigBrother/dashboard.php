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

    <!-- To-Do List Section -->
    <div class="mb-5">
        <h2 class="mb-3 text-center">📝 To-Do List</h2>
        <form class="row g-3 mb-4 justify-content-center" method="POST" action="api/tasks.php">
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

        <!-- Calendar View -->
        <h2 class="text-center mt-5">📅 Task Calendar</h2>
        <div id="calendar" class="mb-5"></div>

        <!-- FullCalendar and Bootstrap Scripts -->
        
            <script>
            const calendarEvents = [
                <?php
                $stmt = $pdo->prepare("SELECT title, deadline FROM tasks WHERE user_id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                foreach ($stmt as $task) {
                    echo "{ title: '" . addslashes($task['title']) . "', start: '" . $task['deadline'] . "' },";
                }
                ?>
            ];
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                if (calendarEl) {
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        events: calendarEvents
                    });
                    calendar.render();
                }
            });
        </script>
        
    </div>

    <!-- Subjects Section -->
    <div class="mb-5">
        <h2 class="mb-3 text-center">📚 Subjects</h2>
        <form class="row g-3 mb-4 justify-content-center" method="POST" action="api/subjects.php">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Subject Name" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="ects" class="form-control" placeholder="ECTS" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add" class="btn btn-success w-100">Add Subject</button>
            </div>
        </form>

        <!-- Subjects Table -->
        <table class="table table-striped table-bordered">
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
                    <!-- Status toggle form -->
                    <td>
                        <form method="POST" action="api/subjects.php" style="display:inline;">
                            <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                            <button type="submit" name="toggle" class="btn btn-sm <?= $subj['is_completed'] ? 'btn-success' : 'btn-secondary' ?>">
                                <?= $subj['is_completed'] ? "✅ Completed" : "❌ Incomplete" ?>
                            </button>
                        </form>
                    </td>

                    <!-- Subject name -->
                    <td><?= htmlspecialchars($subj['name']) ?></td>

                    <!-- ECTS -->
                    <td><?= (int)$subj['ects'] ?></td>

                    <!-- Actions -->
                    <td class="d-flex gap-2">
                        <!-- Add Notes -->
                        <a href="add-note.php?subject_id=<?= $subj['id'] ?>" class="btn btn-primary btn-sm">Add Notes</a>

                        <!-- Edit -->
                        <a href="edit-subject.php?id=<?= $subj['id'] ?>" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete -->
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

    <!-- Stressometer Section -->
    <div class="mb-5">
        <h2 class="mb-3 text-center">😰 Stressometer</h2>
        <form class="row g-3 mb-4 justify-content-center" method="POST" action="api/stress.php">
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="stress_level" class="form-control" min="1" max="10" placeholder="Stress Level (1-10)" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add" class="btn btn-danger w-100">Add Entry</button>
            </div>
        </form>

        <div class="text-center mb-3">
            <button class="btn btn-outline-primary btn-sm me-2" onclick="setStressView('daily')">Täglich</button>
            <button class="btn btn-outline-primary btn-sm me-2" onclick="setStressView('weekly')">Wöchentlich</button>
            <button class="btn btn-outline-primary btn-sm" onclick="setStressView('monthly')">Monatlich</button>
        </div>
        <canvas id="stressChart" height="100"></canvas>
    </div>
</div>
<!-- Stressometer Chart.js & Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let stressChart;
let currentView = 'daily';

function setStressView(view) {
    currentView = view;
    fetch('api/stress.php?view=' + view)
        .then(res => res.json())
        .then(data => {
            let labels = [];
            let values = [];
            if (view === 'daily') {
                labels = data.map(d => d.date);
                values = data.map(d => d.stress_level);
            } else {
                labels = data.map(d => d.label);
                values = data.map(d => d.avg_stress);
            }
            renderStressChart(labels, values, view);
        });
}

function renderStressChart(labels, values, view) {
    const ctx = document.getElementById('stressChart').getContext('2d');
    if (stressChart) stressChart.destroy();
    stressChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: view === 'daily' ? 'Stress Level' : 'Average Stress',
                data: values,
                fill: false,
                borderColor: '#dc3545',
                backgroundColor: '#dc3545',
                tension: 0.2,
                pointRadius: 5
            }]
        },
        options: {
            scales: {
                y: {
                    min: 1,
                    max: 10,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}

// Initial laden
document.addEventListener('DOMContentLoaded', function() {
    setStressView('daily');
});
</script>


<?php include('includes/footer.php'); ?>