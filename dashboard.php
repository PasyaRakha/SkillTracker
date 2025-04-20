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

function isCompletedToday($conn, $skill_id, $today) {
    $check = $conn->prepare("SELECT * FROM skill_progress WHERE skill_id = ? AND progress_date = ?");
    $check->bind_param("is", $skill_id, $today);
    $check->execute();
    return $check->get_result()->num_rows > 0;
}

$today = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Skill Challenge Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-xl p-8 rounded-2xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">👋 Hai, <?= htmlspecialchars($user['username']) ?>!</h1>
            <a href="history.php" class="text-blue-500 hover:underline ml-4">📅 Riwayat</a>
            <a href="logout.php" class="text-red-500 hover:underline">Logout</a>

        </div>

        <div class="mb-6">
            <a href="add_skill.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">➕ Tambah Skill</a>
        </div>

        <?php if ($skill_result->num_rows > 0): ?>
            <?php while ($skill = $skill_result->fetch_assoc()): ?>
                <?php
                    // Hitung progres
                    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM skill_progress WHERE skill_id = ?");
                    $stmt->bind_param("i", $skill['id']);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $progress_data = $res->fetch_assoc();

                    $completed_days = $progress_data['total'];
                    $total_days = $skill['total_days'];
                    $percentage = ($completed_days / $total_days) * 100;
                    $completed = isCompletedToday($conn, $skill['id'], $today);
                ?>
                <div class="border rounded-xl p-4 mb-6 bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($skill['skill_name']) ?></h2>
                    <p class="text-sm text-gray-500 mb-2">Target: <?= $total_days ?> hari</p>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                        <div class="bg-blue-500 h-4 rounded-full transition-all duration-300" style="width: <?= min($percentage, 100) ?>%;"></div>
                    </div>
                    <p class="text-sm text-gray-600 mb-2"><?= $completed_days ?> / <?= $total_days ?> hari selesai (<?= round($percentage) ?>%)</p>

                    <?php if ($completed): ?>
                        <p class="text-green-600">✅ Sudah diselesaikan hari ini!</p>
                    <?php else: ?>
                        <form action="update_progress.php" method="post">
                            <input type="hidden" name="skill_id" value="<?= $skill['id'] ?>">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">✔️ Tandai Selesai Hari Ini</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-gray-600">Kamu belum menambahkan skill apapun. Yuk mulai!</p>
        <?php endif; ?>
    </div>
</body>
</html>
