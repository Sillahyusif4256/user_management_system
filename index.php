<?php
// Include the database connection file
require_once 'db_connect.php';

// Prepare the SQL query to select all users
$sql = "SELECT id, username, role FROM users ORDER BY role, username";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F0EEEEFF;
            margin: 0;
            padding: 20px;
        }
        .charset {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }
    
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .add-button {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .thead {
            background-color: #2463A3FF;
            color: white;
            text-align: center;
            
        }
        .add-button:hover {
            background-color: #218838;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h2>User Roles & Database System</h2>
        <a href="add_user.php" class="add-button">➕ Add New User</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><strong><?php echo htmlspecialchars($row['role']); ?></strong></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found in the database.</p>
        <?php endif; ?>

        <?php $conn->close(); // Close the connection ?>
    </div>
</body>
</html>