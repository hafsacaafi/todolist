<?php
include 'database.php';

// Only accept POST requests to perform deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete all history entries
    $conn->query("DELETE FROM task_history");
}

// Redirect back to history page
header('Location: task_history.php');
exit;
