<?php
session_start();
require_once 'User.php';

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit();
}

$user = new User();
$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
$userData = $user->getUser($id);

if (!$userData) {
    header("location:home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $level = $_POST['level'];
    
    $result = $user->updateUser($id, $email, $fullname, $level);
    
    if ($result === true) {
        header("location:home.php");
        exit();
    } else {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #74b9ff, #a29bfe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .edit-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #1877f2;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 0.5rem;
            text-align: left;
            width: 100%;
        }

        input[type="email"],
        input[type="text"],
        select {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #166fe5;
        }

        .error {
            color: red;
            margin-bottom: 1rem;
        }

        .back-link {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: white;
            background-color: #1877f2;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .back-link:hover {
            background-color: #166fe5;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Profile</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="post" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userData['user_email']); ?>" required>

            <label for="fullname">Nama Lengkap:</label>
            <input type="text" name="fullname" id="fullname" value="<?php echo htmlspecialchars($userData['user_fullname']); ?>" required>

            <label for="level">Level:</label>
            <select name="level" id="level">
                <option value="1" <?php if ($userData['level'] == 1) echo 'selected'; ?>>Admin</option>
                <option value="2" <?php if ($userData['level'] == 2) echo 'selected'; ?>>User</option>
            </select>

            <input type="submit" value="Update">
        </form>
        <a href="home.php" class="back-link">Back to Home</a>
    </div>
</body>
</html>
