<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Ambil semua skill milik user
$skills = $conn->prepare("SELECT * FROM skills WHERE user_id = ?");
$skills->bind_param("i", $user_id);
$skills->execute();
$skill_result = $skills->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat - Skill Challenge Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-xl p-8 rounded-2xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">📅 Riwayat Progress - <?= htmlspecialchars($user['username']) ?></h1>
            <a href="dashboard.php" class="text-blue-500 hover:underline">⬅️ Kembali ke Dashboard</a>
        </div>

        <?php if ($skill_result->num_rows > 0): ?>
            <?php while ($skill = $skill_result->fetch_assoc()): ?>
                <div class="border rounded-xl p-4 mb-6 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2"><?= htmlspecialchars($skill['skill_name']) ?></h2>

                    <?php
                        $history = $conn->prepare("SELECT progress_date FROM skill_progress WHERE skill_id = ? ORDER BY progress_date ASC");
                        $history->bind_param("i", $skill['id']);
                        $history->execute();
                        $history_result = $history->get_result();
                    ?>

                    <?php if ($history_result->num_rows > 0): ?>
                        <ul class="list-disc pl-5 text-sm text-gray-600">
                            <?php while ($row = $history_result->fetch_assoc()): ?>
                                <li><?= date("d M Y", strtotime($row['progress_date'])) ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm">Belum ada progress tercatat.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-gray-600">Kamu belum menambahkan skill apapun.</p>
        <?php endif; ?>
    </div>
</body>
</html>
