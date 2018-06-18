<?php

/**
 * This class handles registering, logging in and other functions related to users
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

class UserActions
{

    private $_PDO;

    public function __construct()
    {
        $this->_PDO = $pdo = new PDO('mysql:host=localhost;dbname=if17_roheline;charset=utf8', 'if17', 'if17');
    }

    public function login($email, $password)
    {
        $user = $this->_checkCredentials($email, $password);
        if ($user) {
            $user = $user; // for accessing it later
            $_SESSION['user_id'] = $user['id'];
            return $user['id'];
        }
        return false;
    }

    protected function _checkCredentials($email, $password)
    {
        $stmt = $this->_PDO->prepare('SELECT id, email, password FROM users WHERE email=? LIMIT 1');
        $stmt->execute(array($email));
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $submitted_pass = hash("sha512", $password);
            if ($submitted_pass == $user['password']) {
                return $user;
            }
        }
        return false;
    }

    public function registerUser($email, $password, $organization)
    {
        //Check if email exists
        $stmt = $this->_PDO->prepare("SELECT email from users WHERE email='$email' LIMIT 1");
        $stmt->bindParam(1, $_GET['email'], PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            $hashed_pass = hash("sha512", $password);
            $stmt = $this->_PDO->prepare("INSERT INTO users (email, password, school) VALUES (?, ?, ?)");
            if (false === $stmt) {
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute(array($email, $hashed_pass, $organization));
            if (false === $stmt) {
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            echo '<script>console.log("Registration success")</script>';
        } else {
            echo 'Email already exists';
        }
    }

    public function getOrganizations()
    {
        $stmt = $this->_PDO->prepare("SELECT id, school_name FROM schools");
        if (false === $stmt) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->execute();
        if (false === $stmt) {
            die('execute() failed: ' . htmlspecialchars($mysqli->error));
        }
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getEmail($user_id)
    {
        $stmt = $this->_PDO->prepare("SELECT email FROM users WHERE id=$user_id LIMIT 1");
        if (false === $stmt) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->execute();
        if (false === $stmt) {
            die('execute() failed: ' . htmlspecialchars($mysqli->error));
        }
        $result = $stmt->fetch();
        $email = $result["email"];
        return $email;
    }

    public function getSchool($user_id)
    {
        $stmt = $this->_PDO->prepare("SELECT school FROM users WHERE id=$user_id LIMIT 1");
        if (false === $stmt) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->execute();
        if (false === $stmt) {
            die('execute() failed: ' . htmlspecialchars($mysqli->error));
        }
        $result = $stmt->fetch();
        $school = $result["school"];
        return $school;
    }
    public function getSchoolName($school_id)
    {
        $stmt = $this->_PDO->prepare("SELECT school_name FROM schools WHERE id=$school_id LIMIT 1");
        if (false === $stmt) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->execute();
        if (false === $stmt) {
            die('execute() failed: ' . htmlspecialchars($mysqli->error));
        }
        $result = $stmt->fetch();
        $schoolname = $result["school_name"];
        return $schoolname;

    }
}
