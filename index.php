<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Skill Challenge Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

    <!-- Header -->
    <header class="bg-blue-600 text-white py-4 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center px-6">
            <h1 class="text-xl font-bold">🔥 Skill Challenge Tracker</h1>
            <div>
                <a href="login.php" class="mr-4 hover:underline">Login</a>
                <a href="register.php" class="bg-white text-blue-600 px-4 py-2 rounded-full hover:bg-gray-100">Daftar</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-16 bg-gray-100 text-center">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-4">Bangun Skill-mu Hari demi Hari</h2>
            <p class="text-lg text-gray-700 mb-6">Skill Challenge Tracker membantumu konsisten meningkatkan kemampuan dengan menantang dirimu sendiri setiap hari.</p>
            <a href="register.php" class="bg-blue-600 text-white px-6 py-3 rounded-full text-lg hover:bg-blue-700 transition">Mulai Sekarang</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-10">Apa yang Bisa Kamu Lakukan?</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">📈 Lacak Progresmu</h4>
                    <p class="text-gray-600">Tandai setiap hari saat kamu menyelesaikan tantangan, dan lihat progress bar-mu terus naik!</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">🗓️ Lihat Riwayat</h4>
                    <p class="text-gray-600">Lihat kapan saja kamu menyelesaikan tantangan dalam tampilan historis yang rapi.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">🔥 Tantang Diri Sendiri</h4>
                    <p class="text-gray-600">Tambahkan skill apapun dan buat target harian yang menantang untuk perkembanganmu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 py-6 text-center text-gray-500">
        <p>© <?= date('Y') ?> Skill Challenge Tracker. Dibuat dengan ❤️</p>
    </footer>

</body>
</html>
