<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Registration failed! Username might already exist. Please try a different username.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TaskMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .register-card {
            max-width: 450px;
            margin: 80px auto;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-icon {
            font-size: 4rem;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        .input-group-text {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <div class="card">
                <div class="card-body">
                    <div class="register-header">
                        <i class="fas fa-user-plus register-icon"></i>
                        <h2 style="font-weight: bold; color: #333;">Create Account</h2>
                        <p style="color: #888;">Join us and start organizing your tasks</p>
                    </div>
                    
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="username" class="form-label"><i class="fas fa-user"></i> Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Choose a strong password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mb-3">
                            <i class="fas fa-user-plus"></i> Create Account
                        </button>
                    </form>
                    
                    <div class="text-center">
                        <p style="color: #888;">Already have an account? <a href="login.php" style="color: #667eea; font-weight: 600;">Login here</a></p>
                        <a href="home.php" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
