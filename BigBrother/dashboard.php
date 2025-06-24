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
                        $stmt = $pdo->prepare("SELECT AVG(grade) AS avg_grade FROM subjects WHERE user_id = ? AND grade IS NOT NULL");
                        $stmt->execute([$_SESSION['user_id']]);
                        $avg = $stmt->fetch(PDO::FETCH_ASSOC);
                        foreach ($stmt as $subj):
                        ?>
                        <tr>
                            <td>
                                <form method="POST" action="api/subjects.php">
                                    <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                                    <button type="submit" name="toggle" class="btn btn-sm <?= $subj['is_completed'] ? 'btn-success' : 'btn-secondary' ?>">
                                        <?= $subj['is_completed'] ? "Finished" : "Started" ?>
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
                        <!-- Durchschnittszeile -->
                            <tr class="table-info fw-bold">
                                <td colspan="2" class="text-end">Ø Notendurchschnitt:</td>
                                <td colspan="2" class="text-start">
                                    <?= ($avg && $avg['avg_grade'] !== null) ? number_format($avg['avg_grade'], 2) : '—' ?>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>


            

        </div>
    </div>

    <!-- Schedule Calendar -->
    <div class="col-12 mb-5">
        <h2 class="mb-3 text-center">📅 Schedule Calendar</h2>
        <div id="calendar"></div>
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

<!-- Add Event Modal -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Event</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="event_name">Event Name</label>
          <input type="text" id="event_name" class="form-control" placeholder="Enter your event name">
        </div>
        <div class="form-group">
          <label for="event_start_date">Start Date</label>
          <input type="date" id="event_start_date" class="form-control">
        </div>
        <div class="form-group">
          <label for="event_end_date">End Date</label>
          <input type="date" id="event_end_date" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="save_event()">Save Event</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    display_events();
});

function display_events() {
    var events = [];
    $.ajax({
        url: 'api/display_event.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            response.data.forEach(function (item) {
                events.push({
                    title: item.event_name,
                    start: item.event_start_date,
                    end: item.event_end_date
                });
            });

            $('#calendar').fullCalendar({
                defaultView: 'month',
                editable: false,
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
                    $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                    $('#event_end_date').val(moment(end).subtract(1, 'days').format('YYYY-MM-DD'));
                    $('#event_entry_modal').modal('show');
                },
                events: events
            });
        }
    });
}

function save_event() {
    const name = $('#event_name').val();
    const start = $('#event_start_date').val();
    const end = $('#event_end_date').val();

    if (!name || !start || !end) {
        alert("Please fill all fields.");
        return;
    }

    $.ajax({
        url: 'api/save_event.php',
        type: 'POST',
        data: {
            event_name: name,
            event_start_date: start,
            event_end_date: end
        },
        success: function (response) {
            $('#event_entry_modal').modal('hide');
            alert("Event saved!");
            location.reload();
        }
    });
}
</script>



<?php include('includes/footer.php'); ?>
