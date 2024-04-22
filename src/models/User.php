<?php
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

    // Get user by name
    public function findByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert new user
    public function create($name, $email, $password)
    {
        try {
            $user = $this->findByEmail($email);

            if ($user) {
                throw new Exception('Email is already taken');
            }

            $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $success = $stmt->execute([$name, $email, $password]);

            if (!$success) {
                throw new Exception("Failed to create user");
            }

            return array($name, $email, $password);

        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }


    // Delete user by ID
    public function delete($id)
    {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Authenticate user

}
