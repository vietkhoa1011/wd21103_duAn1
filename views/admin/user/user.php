<!DOCTYPE html>

<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

```
<h2 class="mb-4">Quản lý người dùng</h2>

<!-- Nút thêm -->
<a href="index.php?action=admin/user/create" class="btn btn-primary mb-3">
    + Thêm user
</a>

<!-- Bảng user -->
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Địa chỉ</th>
                    <th>Role</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone'] ?></td>
                    <td><?= $user['address'] ?></td>
                    <td>
                        <?php if($user['role'] == 'admin'): ?>
                            <span class="badge bg-danger">Admin</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">User</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="index.php?action=admin/user/update&id=<?= $user['id'] ?>" 
                           class="btn btn-warning btn-sm">Sửa</a>

                        <a href="index.php?action=admin/user/delete&id=<?= $user['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Xoá user này?')">
                           Xoá
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
```

</div>

</body>
</html>
