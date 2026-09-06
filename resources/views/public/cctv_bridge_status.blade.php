<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Server CCTV Diskominfo Kab. Banyuasin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #090e17;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }
        .card {
            background: radial-gradient(circle at top, #131c2e 0%, #0c121d 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px 32px;
            max-width: 520px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fbbf24;
            font-size: 32px;
            margin-bottom: 24px;
        }
        h2 { font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 12px; }
        p { font-size: 14px; color: #94a3b8; line-height: 1.6; margin-bottom: 24px; }
        .meta-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: #cbd5e1;
            margin-bottom: 24px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #34d399;
            font-weight: 700;
        }
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }
        .btn-retry {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2563eb;
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: background 0.2s;
            cursor: pointer;
            border: none;
        }
        .btn-retry:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap">
            <i class="fa-solid fa-satellite-dish"></i>
        </div>
        <h2>Bridge Gateway CCTV Banyuasin</h2>
        <p>Jalur koneksi langsung ke server transmisi Diskominfo Pemerintah Kabupaten Banyuasin. Data pemantauan diperbarui secara berkala.</p>
        <div class="meta-box">
            <span>Origin Host</span>
            <span>103.75.150.75</span>
        </div>
        <div class="meta-box">
            <span>Status Transmisi</span>
            <span class="status-badge"><span class="dot"></span> STANDBY BRIDGE</span>
        </div>
        <button onclick="window.location.reload()" class="btn-retry">
            <i class="fa-solid fa-rotate-right"></i> Sinkronisasi Ulang Siaran
        </button>
    </div>
</body>
</html>
