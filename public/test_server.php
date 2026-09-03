<?php
// Diagnostik Server PWI Banyuasin
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

$rootPath = dirname(__DIR__);
$storagePath = $rootPath . '/storage';
$cachePath = $rootPath . '/bootstrap/cache';
$envFile = $rootPath . '/.env';

$phpVersion = phpversion();
$isStorageWritable = is_writable($storagePath);
$isCacheWritable = is_writable($cachePath);
$isEnvExists = file_exists($envFile);

$dbStatus = 'Belum dites';
if ($isEnvExists) {
    $envContent = file_get_contents($envFile);
    preg_match('/DB_DATABASE=(.*)/', $envContent, $dbMatches);
    preg_match('/DB_USERNAME=(.*)/', $envContent, $userMatches);
    preg_match('/DB_PASSWORD=(.*)/', $envContent, $passMatches);
    preg_match('/DB_HOST=(.*)/', $envContent, $hostMatches);

    $dbName = trim($dbMatches[1] ?? '');
    $dbUser = trim($userMatches[1] ?? '');
    $dbPass = trim($passMatches[1] ?? '');
    $dbHost = trim($hostMatches[1] ?? '127.0.0.1');

    try {
        $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
        $dbStatus = '<span style="color: green; font-weight: bold;">Terhubung Berhasil ke MySQL (' . htmlspecialchars($dbName) . ')</span>';
    } catch (Exception $e) {
        $dbStatus = '<span style="color: red; font-weight: bold;">Gagal Konek MySQL: ' . htmlspecialchars($e->getMessage()) . '</span>';
    }
} else {
    $dbStatus = '<span style="color: red;">Berkas .env tidak ditemukan di ' . htmlspecialchars($rootPath) . '</span>';
}

// Cek Laravel Log Error Terakhir
$logFile = $storagePath . '/logs/laravel.log';
$lastLog = 'Tidak ada catatan log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -25);
    $lastLog = implode('', $lastLines);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Diagnostik Server - PWI Banyuasin</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #0f172a; color: #f8fafc; padding: 30px; margin: 0; }
        .card { max-width: 750px; margin: 0 auto; background: #1e293b; border-radius: 12px; padding: 25px; border: 1px solid #334155; }
        h2 { margin-top: 0; color: #38bdf8; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        td { padding: 10px 8px; border-bottom: 1px solid #334155; font-size: 14px; }
        .label { font-weight: bold; width: 220px; color: #94a3b8; }
        pre { background: #090d16; padding: 15px; border-radius: 8px; color: #f43f5e; font-size: 12px; overflow-x: auto; max-height: 250px; }
        .btn { display: inline-block; background: #0284c7; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
<div class="card">
    <h2>Diagnostik Server & Lingkungan Hosting</h2>
    <table>
        <tr>
            <td class="label">Versi PHP Server Web:</td>
            <td><strong><?= htmlspecialchars($phpVersion) ?></strong> <?= version_compare($phpVersion, '8.2.0', '>=') ? '✓ (Memenuhi Syarat)' : '<span style="color: red;">✗ (Harus >= 8.2)</span>' ?></td>
        </tr>
        <tr>
            <td class="label">Status Berkas .env:</td>
            <td><?= $isEnvExists ? '<span style="color: green;">✓ Ditemukan</span>' : '<span style="color: red;">✗ Tidak Ditemukan</span>' ?></td>
        </tr>
        <tr>
            <td class="label">Izin Tulis Folder Storage:</td>
            <td><?= $isStorageWritable ? '<span style="color: green;">✓ Writable (Bisa Ditulis)</span>' : '<span style="color: red;">✗ Permission Denied (Harus chmod 775 / 777)</span>' ?></td>
        </tr>
        <tr>
            <td class="label">Izin Tulis Bootstrap Cache:</td>
            <td><?= $isCacheWritable ? '<span style="color: green;">✓ Writable (Bisa Ditulis)</span>' : '<span style="color: red;">✗ Permission Denied (Harus chmod 775 / 777)</span>' ?></td>
        </tr>
        <tr>
            <td class="label">Koneksi Database MySQL:</td>
            <td><?= $dbStatus ?></td>
        </tr>
    </table>

    <h3 style="margin-top: 25px; color: #cbd5e1; font-size: 15px;">25 Baris Terakhir storage/logs/laravel.log:</h3>
    <pre><?= htmlspecialchars($lastLog) ?></pre>
</div>
</body>
</html>
