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
    }
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}
