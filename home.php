<?php
session_start();
require_once 'User.php';

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit();
}

$user = new User();
$currentUser = $user->getUser($_SESSION['id']);

if (!$currentUser) {
    session_destroy();
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        .home-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 550px;
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

        a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: white;
            background-color: #1877f2;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #166fe5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #1877f2;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-links a {
            margin-right: 0.5rem;
            background-color: #ff4d4f;
        }

        .action-links a:hover {
            background-color: #d9363e;
        }
    </style>
</head>
<body>
    <div class="home-container">
        <h2>Welcome, <?php echo htmlspecialchars($currentUser['user_fullname']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($currentUser['user_email']); ?></p>
        <p>Level: <?php echo $currentUser['level'] == 1 ? 'Admin' : 'User'; ?></p>
        <a href="edit.php">Edit Profile</a>
        <a href="logout.php">Logout</a>

        <?php if ($currentUser['level'] == 1): ?>
            <h3>Daftar Pengguna</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Fullname</th>
                    <th>Action</th>
                </tr>
                <?php
                $users = $user->getAllUsers();
                foreach ($users as $row):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_fullname']); ?></td>
                    <td class="action-links">
                        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
