<?php namespace App\Models;

use PDO;

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Get user by ID
    public function getById($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user by username
    public function getByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert new user
    public function create($username, $email, $password)
    {
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$username, $email, $password]);
    }

    // Update user by ID
    public function update($id, $username, $email, $password)
    {
        $query = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$username, $email, $password, $id]);
    }

    // Delete user by ID
    public function delete($id)
    {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Authenticate user
    public function authenticate($email, $password)
    {
        // Check if email is empty
        if (empty($email)) {
            throw new \InvalidArgumentException("Username cannot be empty");
        }

        // Get user by email
        $user = $this->getByEmail($email);

        // Check if user exists
        if (!$user) {
            throw new \Exception("User not found");
        }

        // Verify password
        // if (!password_verify($password, $user["password"])) {
        if (!($password === $user["password"])) {
            throw new \Exception("Incorrect password");
        }

        // Authentication successful, return user details
        return $user;
    }
}
