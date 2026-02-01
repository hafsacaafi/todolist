<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List with Task History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="text-center text-primary mb-4"><i class="fas fa-tasks"></i> My To-Do List</h2>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <form method="POST" action="">
                        <button type="submit" class="btn btn-danger" name="logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                        <i class="fas fa-plus-circle"></i> Add Task
                    </button>
                    <a href="task_history.php" class="btn btn-secondary">
                        <i class="fas fa-history"></i> Task History
                    </a>
                </div>

                <hr>

                <!-- Task List -->
                <ul id="taskList" class="list-group"></ul>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add New Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="taskInput" class="form-label"><i class="fas fa-pencil-alt"></i> Task Description</label>
                        <input type="text" id="taskInput" class="form-control" placeholder="Enter your task..." required>
                    </div>
                    <div class="mb-3">
                        <label for="dueDateInput" class="form-label"><i class="fas fa-calendar-alt"></i> Due Date</label>
                        <input type="date" id="dueDateInput" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button class="btn btn-primary" id="addTaskBtn">
                        <i class="fas fa-save"></i> Save Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editTaskId">
                    <div class="mb-3">
                        <label for="editTaskInput" class="form-label"><i class="fas fa-pencil-alt"></i> Task Description</label>
                        <input type="text" id="editTaskInput" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editDueDateInput" class="form-label"><i class="fas fa-calendar-alt"></i> Due Date</label>
                        <input type="date" id="editDueDateInput" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button class="btn btn-primary" id="saveEditTask">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadTasks() {
                $.ajax({
                    url: "fetch_tasks.php",
                    type: "GET",
                    success: function (data) {
                        $("#taskList").html(data);
                    }
                });
            }

            loadTasks();

            $("#addTaskBtn").click(function () {
                var task = $("#taskInput").val();
                var due_date = $("#dueDateInput").val();
                if (task && due_date) {
                    $.post("add_task.php", { task: task, due_date: due_date }, function () {
                        $("#taskInput").val("");
                        $("#dueDateInput").val("");
                        $("#addTaskModal").modal("hide");
                        loadTasks();
                    });
                }
            });

            $(document).on("click", ".edit-task", function () {
                $("#editTaskId").val($(this).data("id"));
                $("#editTaskInput").val($(this).data("task"));
                $("#editDueDateInput").val($(this).data("due"));
                $("#editTaskModal").modal("show");
            });

            $("#saveEditTask").click(function () {
                var id = $("#editTaskId").val();
                var task = $("#editTaskInput").val();
                var due_date = $("#editDueDateInput").val();
                $.post("update_task.php", { id: id, task: task, due_date: due_date }, function () {
                    $("#editTaskModal").modal("hide");
                    loadTasks();
                });
            });

            $(document).on("click", ".progress-task", function () {
                var id = $(this).data("id");
                $.get("progress_task.php?id=" + id, function () {
                    loadTasks();
                });
            });

            $(document).on("click", ".complete-task", function () {
                var id = $(this).data("id");
                $.get("complete_task.php?id=" + id, function () {
                    loadTasks();
                });
            });

            $(document).on("click", ".delete-task", function () {
                var id = $(this).data("id");
                $.get("delete_task.php?id=" + id, function () {
                    loadTasks();
                });
            });
        });
    </script>
</body>
</html>





