<?php
session_start();
require_once 'User.php';

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $result = $user->login($email, $password);
    
    if ($result) {
        $_SESSION['id'] = $result['id'];
        $_SESSION['email'] = $email;
        $_SESSION['level'] = $result['level'];
        header("location:home.php");
        exit();
    } else {
        $error = "Email atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #74b9ff, #a29bfe);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            color: #2d3436;
            margin-bottom: 1.5rem;
        }

        .error {
            color: red;
            margin-bottom: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #dfe6e9;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #74b9ff;
        }

        input[type="submit"] {
            background-color: #0984e3;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #74b9ff;
        }

        .register-link {
            margin-top: 1rem;
        }

        .register-link a {
            color: #0984e3;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <div class="register-link">
            <p>Belum Memiliki Akun? <a href="register.php">Daftar</a></p>
        </div>
    </div>
</body>
</html>
