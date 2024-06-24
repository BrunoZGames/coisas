<?php
session_set_cookie_params([
    'lifetime' => 0, // Session cookie will expire when the browser is closed
    'path' => '/', // Available within the entire domain
    'domain' => '', // Default domain
    'secure' => false, // Set to true if using HTTPS
    'httponly' => true, // Accessible only through HTTP protocol
    'samesite' => 'Lax' // Cross-site request forgery protection
]);
session_start();

// Database connection settings
$servername = "localhost";
$dbname = "fujimoto_barbershop";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Function to generate a random token
function generateToken()
{
    return bin2hex(random_bytes(16)); // Generates a 32-character token
}

// Function to register a new user
function registerUser($conn, $username, $password, $email, $name, $lastname, $phone)
{
    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Nome de Usuario ou email já existem.";
        $stmt->close();
        return false;
    }
    $stmt->close();
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, name, last_name, phonenumber, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $hashed_password, $email, $name, $lastname, $phone, $created_at);

    // Execute the query
    if ($stmt->execute()) {
        echo "Registration successful!";
        LoginUser($conn, $username, $password);
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Function to login a user
function loginUser($conn, $username, $password)
{
    // Prepare and bind
    $stmt = $conn->prepare("SELECT user_id, username, password, email, name, last_name, phonenumber, role_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();

    // Store the result
    $stmt->store_result();

    // Check if username exists
    if ($stmt->num_rows > 0) {
        // Bind the result
        $stmt->bind_result($user_id, $username, $hashed_password, $email, $name, $lastname, $phone, $role_id);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Generate a token
            $token = generateToken();

            // Update the user's token in the database
            $update_stmt = $conn->prepare("UPDATE users SET token = ? WHERE user_id = ?");
            $update_stmt->bind_param("si", $token, $user_id);
            $update_stmt->execute();
            $update_stmt->close();

            // Store user info in an array
            $user_info = array(
                'user_id' => $user_id,
                'username' => $username,
                'email' => $email,
                'name' => $name,
                'lastname' => $lastname,
                'phone' => $phone
            );

            // Store the token and user info in the session
            $_SESSION['token'] = $token;
            $_SESSION['user_info'] = $user_info;
            $_SESSION['success'] = "Login successful! Welcome, " . $username;
            $_SESSION["role"] = $role_id;
            header("Location: ../logged.php");
            exit();
        } else {
            $_SESSION['error'] = "Password incorrecta.";
        }
    } else {
        $_SESSION['error'] = "Nenhum usuario encontrado com esse nome de usuario.";
    }

    // Close statement
    $stmt->close();

}

// Middleware to check if the user is authenticated
function isAuthenticated($conn)
{
    if (!isset($_SESSION['token'])) {
        return false;
    }

    $token = $_SESSION['token'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);

    // Execute the query
    $stmt->execute();

    // Store the result
    $stmt->store_result();

    // Check if a user with the token exists
    $authenticated = $stmt->num_rows > 0;

    // Close statement
    $stmt->close();

    return $authenticated;
}

// Middleware to check if the user is an admin
function isAdmin($conn)
{
    if (!isset($_SESSION['token'])) {
        return false;
    }

    $token = $_SESSION['token'];

    // Prepare statement to fetch role_name from users and roles tables
    $stmt = $conn->prepare("SELECT r.role_name 
                            FROM users u 
                            JOIN role_type r ON u.role_id = r.role_id 
                            WHERE u.token = ?");
    $stmt->bind_param("s", $token);

    // Execute the query
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($role_name);

    // Fetch the result
    $stmt->fetch();

    // Close statement
    $stmt->close();

    // Check if role_name matches "Admin"
    return $role_name === "administrador";
}

// Function to change the user's password
function changePassword($conn, $user_id, $current_password, $new_password) {
    // Fetch the current password hash from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the current password
        if (password_verify($current_password, $hashed_password)) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_hashed_password, $user_id);
            $update_stmt->execute();
            $update_stmt->close();

            $_SESSION['success'] = "Password changed successfully!";
        } else {
            $_SESSION['error'] = "Current password is incorrect.";
        }
    } else {
        $_SESSION['error'] = "User not found.";
    }

    // Close statement
    $stmt->close();
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'register') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        registerUser($conn, $username, $password, $email, $name, $lastname, $phone);
    } elseif ($action == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        loginUser($conn, $username, $password);
    } elseif ($action == 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $user_id = $_SESSION['user_info']['id'];

        if ($new_password === $confirm_password) {
            changePassword($conn, $user_id, $current_password, $new_password);
        } else {
            $_SESSION['error'] = "New password and confirm password do not match.";
        }
    }
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}
