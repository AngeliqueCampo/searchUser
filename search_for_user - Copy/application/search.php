<?php
session_start();
require_once '../core/models.php';

if (!isset($_SESSION['userID'])) {
    header('Location: ../users/login.php');
    exit();
}

$searchTerm = trim($_GET['search'] ?? '');
$results = searchApplicants($searchTerm);

// Fetch and clear session messages
$message = $_SESSION['message'] ?? '';
$status = $_SESSION['status'] ?? '';
unset($_SESSION['message'], $_SESSION['status']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../styles/styles.css">
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
            max-width: 900px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border: 2px solid #333;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            text-align: left;
            margin-bottom: 20px;
        }

        input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        .alert {
            margin: 10px auto;
            padding: 15px;
            border-radius: 5px;
            width: 90%;
            max-width: 900px;
            text-align: center;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display messages -->
        <?php if (!empty($message)): ?>
            <div class="alert <?= $status === '200' ? 'success' : 'error'; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <h2>Search Results</h2>

        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search applicants..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Cause</th>
                    <th>Skills</th>
                    <th>Experience</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['firstName']); ?></td>
                        <td><?php echo htmlspecialchars($result['lastName']); ?></td>
                        <td><?php echo htmlspecialchars($result['cause']); ?></td>
                        <td><?php echo htmlspecialchars($result['skills']); ?></td>
                        <td><?php echo htmlspecialchars($result['experience']); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $result['applicationID']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $result['applicationID']; ?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No results found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
