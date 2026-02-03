<?php include 'database.php';
$history_count = $conn->query("SELECT COUNT(*) as cnt FROM task_history")->fetch_assoc()['cnt'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task History - TaskMaster</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .history-icon {
            font-size: 1.2rem;
            margin-right: 10px;
        }
        .history-item {
            transition: all 0.3s ease;
        }
        .history-item:hover {
            background: #f8f9fa;
        }
        .completed-date {
            font-size: 0.85rem;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center text-primary mb-4">
                    <i class="fas fa-history"></i> Task History
                </h2>
                
                <div class="mb-4">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to To-Do List
                    </a>
                    <?php if ($history_count > 0): ?>
                        <form action="clear_history.php" method="post" onsubmit="return confirm('Are you sure you want to clear all task history? This cannot be undone.');" class="d-inline ms-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Clear History
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <ul class="list-group">
                    <?php
                    $result = $conn->query("SELECT * FROM task_history ORDER BY completed_at DESC");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $badge = ($row["status"] == "completed") 
                                ? '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Completed</span>' 
                                : '<span class="badge bg-danger"><i class="fas fa-times-circle"></i> Deleted</span>';
                            
                            $icon = ($row["status"] == "completed") 
                                ? '<i class="fas fa-check-circle text-success history-icon"></i>' 
                                : '<i class="fas fa-trash-alt text-danger history-icon"></i>';
                            
                            echo '<li class="list-group-item history-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        '.$icon.'
                                        <div>
                                            <span style="font-weight: 500;">'.$row["task"].'</span><br>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i> Due: '.$row["due_date"].' | 
                                                <i class="fas fa-clock"></i> Completed: '.$row["completed_at"].'
                                            </small>
                                        </div>
                                    </div>
                                    '.$badge.'
                                </li>';
                        }
                    } else {
                        echo '<li class="list-group-item text-center" style="padding: 40px;">
                                <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                                <p style="color: #888; margin: 0;">No task history yet. Complete or delete some tasks to see them here.</p>
                              </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
