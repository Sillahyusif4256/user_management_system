<?php
require_once 'db_connect.php';

$username = $password = $role = "";
$username_err = $password_err = $role_err = "";
$success_msg = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // 1. Validate Username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement to check if username already exists
        $sql = "SELECT id FROM users WHERE username = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);

            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    // 2. Validate Password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // 3. Validate Role
    $valid_roles = ['Admin', 'Player', 'Agent', 'Club Manager'];
    if(empty($_POST["role"]) || !in_array($_POST["role"], $valid_roles)){
        $role_err = "Please select a valid role.";
    } else {
        $role = $_POST["role"];
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($role_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
         
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_password, $param_role);
            
            // Set parameters
            $param_username = $username;
            // NOTE: In a real system, use password_hash($password, PASSWORD_DEFAULT)
            $param_password = $password; 
            $param_role = $role;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $success_msg = "User **" . htmlspecialchars($username) . "** with role **" . htmlspecialchars($role) . "** created successfully!";
                $username = $password = $role = ""; // Clear form fields
            } else{
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }   
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .help-block { color: red; font-size: 0.9em; }
        .success-msg { color: green; font-weight: bold; margin-bottom: 15px; border: 1px solid #d4edda; background-color: #d4edda; padding: 10px; border-radius: 5px; }
        .back-link { display: inline-block; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New User</h2>
        <?php if (!empty($success_msg)): ?>
            <div class="success-msg"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($role_err)) ? 'has-error' : ''; ?>">
                <label>Role</label>
                <select name="role">
                    <option value="">-- Select Role --</option>
                    <option value="Admin" <?php echo ($role === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Player" <?php echo ($role === 'Player') ? 'selected' : ''; ?>>Player</option>
                    <option value="Agent" <?php echo ($role === 'Agent') ? 'selected' : ''; ?>>Agent</option>
                    <option value="Club Manager" <?php echo ($role === 'Club Manager') ? 'selected' : ''; ?>>Club Manager</option>
                </select>
                <span class="help-block"><?php echo $role_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>
            <a href="index.php" class="back-link">← Back to User List</a>
        </form>
    </div>
</body>
</html>