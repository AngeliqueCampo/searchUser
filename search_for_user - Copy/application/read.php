<?php
session_start();
require_once '../core/models.php';

if (!isset($_SESSION['userID'])) {
    header('Location: ../users/login.php');
    exit();
}

$applicantsData = getAllApplicants(); 
$applicants = $applicantsData['querySet']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicants</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh;
            padding-top: 20px; 
            margin: 0;
            overflow-y: auto; 
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

        input[type="text"] {
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
            margin-top: 20px; 
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Applicants</h2>

        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search applicants...">
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
                <?php foreach ($applicants as $applicant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($applicant['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($applicant['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($applicant['cause']); ?></td>
                    <td><?php echo htmlspecialchars($applicant['skills']); ?></td>
                    <td><?php echo htmlspecialchars($applicant['experience']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $applicant['applicationID']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $applicant['applicationID']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
