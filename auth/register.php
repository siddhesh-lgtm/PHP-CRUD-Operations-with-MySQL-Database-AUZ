<?php
session_start();
include '../config/connect.php';

if (isset($_POST['register'])) {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, role, address, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $role, $address, $password);
        $stmt->execute();
        $_SESSION['user'] = ['full_name' => $name, 'role' => $role];
        header("Location: ../index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 col-md-4">
  <h3 class="text-center mb-3">User Registration</h3>
  <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="POST">
    <input type="text" name="full_name" class="form-control mb-2" placeholder="Full Name" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <select name="role" class="form-control mb-2">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <input type="text" name="phone" class="form-control mb-2" placeholder="Phone">
    <textarea name="address" class="form-control mb-2" placeholder="Address"></textarea>
    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
  </form>
  <p class="text-center mt-2">Already registered? <a href="login.php">Login here</a></p>
</div>
</body>
</html>