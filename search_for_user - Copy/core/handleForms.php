<?php
require_once 'dbConfig.php';
require_once 'models.php';

session_start();

function setSessionMessage($message, $status) {
    $_SESSION['message'] = $message;
    $_SESSION['status'] = $status;
}

function redirectTo($location) {
    header("Location: $location");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // User Registration
    if (isset($_POST['register'])) {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $username = trim($_POST['username']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
            global $pdo;

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetchColumn()) {
                setSessionMessage("Username already exists. Please choose a different username.", 400);
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                if (registerUser($firstName, $lastName, $username, $email, $hashedPassword)) {
                    setSessionMessage("Account successfully registered.", 200);
                    redirectTo('../users/login.php');
                } else {
                    setSessionMessage("Registration failed. Please try again.", 400);
                }
            }
        } else {
            setSessionMessage("Invalid email or password too short (minimum 6 characters).", 400);
        }
        redirectTo('../users/register.php');
    }

    // User Login
    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {
            if (loginUser($username, $password)) {
                setSessionMessage("Login successful.", 200);
                redirectTo('../index.php');
            } else {
                setSessionMessage("Invalid username or password.", 400);
            }
        } else {
            setSessionMessage("Please fill out all fields.", 400);
        }
        redirectTo('../users/login.php');
    }

    // Applicant Creation
    if (isset($_POST['createApplicant'])) {
        $userID = $_POST['userID'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $cause = $_POST['cause'];
        $skills = $_POST['skills'];
        $experience = $_POST['experience'];

        if (createApplicant($userID, $firstName, $lastName, $cause, $skills, $experience)) {
            setSessionMessage("Applicant successfully created.", 200);
        } else {
            setSessionMessage("Applicant creation failed.", 400);
        }
        redirectTo('../application/create.php');
    }

    // Applicant Update
    if (isset($_POST['updateApplicant'])) {
        $applicationID = $_POST['applicationID'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $cause = $_POST['cause'];
        $skills = $_POST['skills'];
        $experience = $_POST['experience'];

        if (updateApplicant($applicationID, $firstName, $lastName, $cause, $skills, $experience)) {
            setSessionMessage("Applicant successfully updated.", 200);
        } else {
            setSessionMessage("Applicant update failed.", 400);
        }
        redirectTo("../application/create.php?id=$applicationID");
    }

    // Applicant Deletion
    if (isset($_POST['deleteApplicant'])) {
        $applicationID = $_POST['applicationID'];

        if (deleteApplicant($applicationID)) {
            setSessionMessage("Applicant successfully deleted.", 200);
        } else {
            setSessionMessage("Applicant deletion failed.", 400);
        }
        redirectTo('../application/create.php');
    }
}
?>
