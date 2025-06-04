<?php
include('../includes/auth.php');
include('../includes/db.php');

// Check if subject id is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid subject ID.');
}

$subject_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch subject info, confirm it belongs to the logged in user
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $user_id]);
$subject = $stmt->fetch();

if (!$subject) {
    die('Subject not found or access denied.');
}

// Handle new note submission with file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note_text'])) {
    $note_text = trim($_POST['note_text']);
    $file_path = null;
    $file_type = null;

    if (isset($_FILES['note_file']) && $_FILES['note_file']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'text/plain']; // extend as needed
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $tmp_name = $_FILES['note_file']['tmp_name'];
        $original_name = basename($_FILES['note_file']['name']);
        $file_type_uploaded = mime_content_type($tmp_name);

        if (in_array($file_type_uploaded, $allowed_types)) {
            // Create unique file name
            $new_filename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original_name);
            $destination = $upload_dir . $new_filename;

            if (move_uploaded_file($tmp_name, $destination)) {
                $file_path = 'uploads/' . $new_filename;
                $file_type = $file_type_uploaded;
            }
        } else {
            die('Unsupported file type uploaded.');
        }
    }

    if ($note_text !== '' || $file_path !== null) {
        $insert = $pdo->prepare("INSERT INTO notes (subject_id, user_id, content, file_path, file_type, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $insert->execute([$subject_id, $user_id, $note_text, $file_path, $file_type]);
        // Redirect to avoid form resubmission
        header("Location: subject.php?id=$subject_id");
        exit;
    }
}

// Fetch all notes for this subject
$notes_stmt = $pdo->prepare("SELECT * FROM notes WHERE subject_id = ? AND user_id = ? ORDER BY created_at DESC");
$notes_stmt->execute([$subject_id, $user_id]);
$notes = $notes_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Notes for <?= htmlspecialchars($subject['name']) ?></title>
</head>
<body>
    <h1>Subject: <?= htmlspecialchars($subject['name']) ?></h1>
    <p>ECTS: <?= htmlspecialchars($subject['ects']) ?></p>

    <h2>Add Note</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <textarea name="note_text" rows="4" cols="50" placeholder="Enter note here..."></textarea><br>
        <label>Attach file (optional): <input type="file" name="note_file" accept="image/*,application/pdf,text/plain"></label><br>
        <button type="submit">Add Note</button>
    </form>

    <h2>Notes</h2>
    <?php if (count($notes) === 0): ?>
        <p>No notes yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($notes as $note): ?>
                <li>
                    <?= nl2br(htmlspecialchars($note['content'])) ?><br>
                    <?php if ($note['file_path']): 
                        $file_url = '../' . $note['file_path'];
                        if (str_starts_with($note['file_type'], 'image/')): ?>
                            <a href="<?= htmlspecialchars($file_url) ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?= htmlspecialchars($file_url) ?>" alt="Note image" style="max-width:200px; max-height:200px;">
                            </a><br>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars($file_url) ?>" target="_blank" rel="noopener noreferrer">Download attached file</a><br>
                        <?php endif; 
                    endif; ?>
                    <small>Added on <?= htmlspecialchars($note['created_at']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="../dashboard.php">Back to Subjects</a></p>
</body>
</html>
