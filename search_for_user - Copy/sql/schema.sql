CREATE TABLE users (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL,  
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applications (
    applicationID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT NOT NULL,
    cause VARCHAR(100) NOT NULL,
    skills TEXT,
    experience TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL;
    FOREIGN KEY (userID) REFERENCES users(userID)
);
