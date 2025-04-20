<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['skill_id'])) {
    $skill_id = intval($_POST['skill_id']);
    $date = date("Y-m-d");

    // Cegah duplikasi data untuk hari yang sama
    $check = $conn->prepare("SELECT * FROM skill_progress WHERE skill_id = ? AND progress_date = ?");
    $check->bind_param("is", $skill_id, $date);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        $insert = $conn->prepare("INSERT INTO skill_progress (skill_id, progress_date) VALUES (?, ?)");
        $insert->bind_param("is", $skill_id, $date);
        $insert->execute();
    }
}

header("Location: dashboard.php");
exit;
