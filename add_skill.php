<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_name = $_POST['skill_name'];
    $total_days = intval($_POST['total_days']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO skills (user_id, skill_name, total_days) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $skill_name, $total_days);
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal menambahkan skill.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Skill - Skill Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <form method="post" class="bg-white shadow-xl p-8 rounded-2xl w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-blue-600">➕ Tambah Skill Baru</h2>

        <?php if (isset($error)) echo "<p class='text-red-500 mb-2'>$error</p>"; ?>

        <label class="block mb-2 text-sm font-medium">Nama Skill:</label>
        <input type="text" name="skill_name" required class="w-full p-2 border rounded mb-4" placeholder="Contoh: Belajar PHP" />

        <label class="block mb-2 text-sm font-medium">Durasi (Hari):</label>
        <input type="number" name="total_days" min="1" value="30" class="w-full p-2 border rounded mb-4" />

        <div class="flex justify-between items-center">
            <a href="dashboard.php" class="text-gray-500 hover:underline">← Kembali</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan</button>
        </div>
    </form>
</body>
</html>
