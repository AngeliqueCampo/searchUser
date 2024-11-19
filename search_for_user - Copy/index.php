<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header('Location: users/login.php');
    exit();
}

$username = $_SESSION['username'] ?? ''; // Get the username from the session
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message'], $_SESSION['status']); // Clear message after displaying
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles/styles.css">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 700px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border: 2px solid #333;
            text-align: center;
        }

        .logout-top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logout-top-right a {
            color: #d9534f;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .logout-top-right a:hover {
            text-decoration: underline;
        }

        .status-message {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 16px;
            font-weight: bold;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid green;
            color: green;
        }

        h1 {
            font-size: 28px;
            font-family: 'Playfair Display', serif;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline-block;
            margin: 0 10px;
        }

        nav ul li a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Display status message -->
    <?php if (!empty($message)): ?>
        <div class="status-message">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Logout link -->
    <div class="logout-top-right">
        <a href="users/logout.php">Logout</a>
    </div>

    <!-- Main content -->
    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($username); ?>!</h1>
        <p>This is the Job Applicant Management System.</p>

        <nav>
            <ul>
                <li><a href="application/create.php">Create Applicant</a></li><br><br>
                <li><a href="application/read.php">View Applicants</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
