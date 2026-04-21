    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            .sidebar {
                width: 220px;
                height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                background: #1e293b;
                color: white;
                padding: 20px;
            }

            .sidebar h2 {
                margin-bottom: 20px;
            }

            .sidebar a {
                display: block;
                padding: 10px;
                color: #cbd5e1;
                text-decoration: none;
                border-radius: 6px;
                margin-bottom: 8px;
                transition: 0.3s;
            }

            .sidebar a:hover {
                background: #334155;
                color: white;
            }
        </style>
    </head>

    <body>
        <div class="sidebar">
            <h2>📚 Admin</h2>
            <a href="index.php?action=/book">📖 Quản lý sách</a>
            <a href="index.php?action=/user">👤 Quản lý user</a>
            <a href="index.php?action=/category">📂 Danh mục</a>
            <a href="index.php?action=/order">📦 Quản lý đơn hàng</a>
            <a href="index.php?action=/admin/review">💬 Quản lý bình luận</a>
            <a href="index.php?action=/statistics">📊 Thống kê</a>
            <a href="index.php?action=/logout">🚪 Đăng xuất</a>
            <div class="mt-3">
                <a href="index.php?action=/" class="btn btn-secondary">Quay lại trang chủ</a>
            </div>
        </div>

    </body>

    </html>