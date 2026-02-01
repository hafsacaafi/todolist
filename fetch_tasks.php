<?php
include 'database.php';

$today = date('Y-m-d');
$conn->query("UPDATE tasks SET status='overdue' WHERE due_date < '$today' AND status='pending'");

$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
$output = '';

while ($row = $result->fetch_assoc()) {
    // Use switch-case instead of match() for compatibility
    $statusBadge = '';
    $statusIcon = '';
    switch ($row["status"]) {
        case "pending":
            $statusBadge = '<span class="badge bg-warning"><i class="fas fa-clock"></i> Pending</span>';
            $statusIcon = '<i class="fas fa-hourglass-start text-warning"></i>';
            break;
        case "in progress":
            $statusBadge = '<span class="badge bg-primary"><i class="fas fa-spinner"></i> In Progress</span>';
            $statusIcon = '<i class="fas fa-tasks text-primary"></i>';
            break;
        case "completed":
            $statusBadge = '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Completed</span>';
            $statusIcon = '<i class="fas fa-check-double text-success"></i>';
            break;
        case "overdue":
            $statusBadge = '<span class="badge bg-danger"><i class="fas fa-exclamation-triangle"></i> Overdue</span>';
            $statusIcon = '<i class="fas fa-exclamation-circle text-danger"></i>';
            break;
    }

    $progressButton = ($row["status"] == "pending") ? '<button class="btn btn-info btn-sm progress-task" data-id="'.$row["id"].'"><i class="fas fa-play"></i> Start</button>' : '';
    $completeButton = ($row["status"] == "in progress") ? '<button class="btn btn-success btn-sm complete-task" data-id="'.$row["id"].'"><i class="fas fa-check"></i> Complete</button>' : '';

    $output .= '
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            '.$statusIcon.'
            <div>
                <span style="font-weight: 500;">'.$row["task"].'</span><br>
                <small class="text-muted"><i class="fas fa-calendar"></i> Due: '.$row["due_date"].'</small>
                '.$statusBadge.'
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            '.$progressButton.'
            '.$completeButton.'
            <button class="btn btn-warning btn-sm edit-task" data-id="'.$row["id"].'" data-task="'.$row["task"].'" data-due="'.$row["due_date"].'"><i class="fas fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm delete-task" data-id="'.$row["id"].'"><i class="fas fa-trash"></i> Delete</button>
        </div>
    </li>';
}

echo $output;
?>



