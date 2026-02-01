<?php
// If the user is already logged in, redirect them to the To-Do List page
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: todolist.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 60px 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }
        .welcome-icon {
            font-size: 5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        .feature-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 15px 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .feature-box:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="welcome-card text-center">
            <i class="fas fa-clipboard-list welcome-icon"></i>
            <h1 class="display-4 mb-4" style="font-weight: bold; color: #333;">Welcome to TaskMaster!</h1>
            <p class="lead mb-5" style="color: #666;">Organize your life, one task at a time. Manage your tasks efficiently with our beautiful and easy-to-use system.</p>
            
            <div class="row justify-content-center mb-5">
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box">
                        <i class="fas fa-tasks feature-icon" style="color: #667eea;"></i>
                        <h5>Track Tasks</h5>
                        <p style="color: #888;">Keep all your tasks organized in one place</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box">
                        <i class="fas fa-calendar-check feature-icon" style="color: #11998e;"></i>
                        <h5>Set Deadlines</h5>
                        <p style="color: #888;">Never miss a deadline with due date tracking</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box">
                        <i class="fas fa-chart-line feature-icon" style="color: #f5576c;"></i>
                        <h5>Track Progress</h5>
                        <p style="color: #888;">Monitor your productivity and achievements</p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center mt-4">
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="login.php" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="register.php" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
