<?php 

session_start();
require_once "db.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $number = $_POST['number'];

    $checkEmail = $conn->query("SELECT email FROM student WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO student (name, student_id, email, password, gender, number) VALUES ('$name', '$student_id', '$email', '$password', '$gender', '$number')");
    }

    header("Location: login.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM student WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $username = $result->fetch_assoc();
        if (password_verify($password, $username['password'])) {
            $_SESSION['email'] = $username['email'];

            header("Location: login.php");
            exit();
        }
    }

    $_SESSION['login_error'] = 'Invalid email or password!';
    $_SESSION['active_form'] = 'login';
    header("Location: login.php");
    exit();
}
?>