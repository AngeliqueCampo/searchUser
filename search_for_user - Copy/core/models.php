<?php
require_once 'dbConfig.php';

// register a new user
function registerUser($firstName, $lastName, $username, $email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO users (firstName, lastName, username, email, password)
        VALUES (?, ?, ?, ?, ?)
    ");
    return $stmt->execute([$firstName, $lastName, $username, $email, $password]);
}

// user login
function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username']; 
        return true;
    }
    return false;
}

// create a new applicant
function createApplicant($userID, $firstName, $lastName, $cause, $skills, $experience) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO applications (userID, firstName, lastName, cause, skills, experience) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userID, $firstName, $lastName, $cause, $skills, $experience]);
        return [
            'message' => 'Applicant created successfully.',
            'statusCode' => 200,
            'querySet' => [] 
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to create applicant: ' . $e->getMessage(),
            'statusCode' => 400,
            'querySet' => [] 
        ];
    }
}

// update existing applicant
function updateApplicant($applicationID, $firstName, $lastName, $cause, $skills, $experience) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE applications 
                               SET firstName = ?, lastName = ?, cause = ?, skills = ?, experience = ? 
                               WHERE applicationID = ?");
        $stmt->execute([$firstName, $lastName, $cause, $skills, $experience, $applicationID]);
        
        return [
            'message' => 'Applicant updated successfully.',
            'statusCode' => 200,
            'querySet' => [] 
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to update applicant: ' . $e->getMessage(),
            'statusCode' => 400,
            'querySet' => [] 
        ];
    }
}


// delete an applicant
function deleteApplicant($applicationID) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM applications WHERE applicationID = ?");
        $stmt->execute([$applicationID]);

        return [
            'message' => 'Applicant deleted successfully.',
            'statusCode' => 200,
            'querySet' => [] 
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to delete applicant: ' . $e->getMessage(),
            'statusCode' => 400,
            'querySet' => [] 
        ];
    }
}


// fetch all applicants
function getAllApplicants() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM applications");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'message' => 'Applicants retrieved successfully.',
            'statusCode' => 200,
            'querySet' => $result 
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to retrieve applicants: ' . $e->getMessage(),
            'statusCode' => 400,
            'querySet' => [] 
        ];
    }
}


// search for applicants 
function searchApplicants($searchTerm) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT 
                applicationID, firstName, lastName, cause, skills, experience 
            FROM applications 
            WHERE firstName LIKE ? 
               OR lastName LIKE ? 
               OR cause LIKE ? 
               OR skills LIKE ? 
               OR experience LIKE ?");
        $searchTermWithWildcard = '%' . $searchTerm . '%';
        $stmt->execute([
            $searchTermWithWildcard,
            $searchTermWithWildcard,
            $searchTermWithWildcard,
            $searchTermWithWildcard,
            $searchTermWithWildcard
        ]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results ?: []; // return an empty array if no results
    } catch (Exception $e) {
        return []; 
}
}
?>
