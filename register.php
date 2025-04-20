<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Gagal registrasi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="post" class="bg-white p-8 rounded-xl shadow-md w-full max-w-sm">
        <h2 class="text-xl font-bold mb-4 text-center">Daftar Akun</h2>
        <input name="username" required placeholder="Username" class="w-full mb-3 p-2 border rounded" />
        <input name="password" type="password" required placeholder="Password" class="w-full mb-3 p-2 border rounded" />
        <button class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600">Daftar</button>
        <p class="text-sm text-center mt-4">Sudah punya akun? <a href="login.php" class="text-blue-500">Login</a></p>
    </form>
</body>
</html>
