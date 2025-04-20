<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="post" class="bg-white p-8 rounded-xl shadow-md w-full max-w-sm">
        <h2 class="text-xl font-bold mb-4 text-center">Masuk Akun</h2>
        <?php if (!empty($error)) echo "<p class='text-red-500 text-sm mb-2'>$error</p>"; ?>
        <input name="username" required placeholder="Username" class="w-full mb-3 p-2 border rounded" />
        <input name="password" type="password" required placeholder="Password" class="w-full mb-3 p-2 border rounded" />
        <button class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600">Masuk</button>
        <p class="text-sm text-center mt-4">Belum punya akun? <a href="register.php" class="text-blue-500">Daftar</a></p>
    </form>
</body>
</html>
