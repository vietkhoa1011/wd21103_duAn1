<?php
if (!isset($users)) {
    $users = [];
}
if (!isset($orders)) {
    $orders = [];
}

?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ Khách hàng - BookStore</title>
    <!-- Nhúng Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Nhúng Font Awesome cho các biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 10px;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            background-color: #0d6efd;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Thanh điều hướng (Header) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?action=/"><i class="fas fa-book-open me-2 text-primary"></i>SmartBooks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sách mới</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Khuyến mãi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Tài khoản</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <div class="container flex-grow-1 py-2">
        
        <!-- Breadcrumb điều hướng -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Tài khoản</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hồ sơ của tôi</li>
            </ol>
        </nav>

        <div class="row">   
            <?php foreach ($users as $user) :?>
            <!-- Cột trái: Thông tin cơ bản và Avatar -->
            <div class="col-lg-4 mb-4">
                
                <div class="card mb-4 text-center">
                    <div class="card-body">
                        <img src="https://i.pravatar.cc/300?img=68" alt="Avatar" class="rounded-circle profile-img mb-3">
                        <h4 class="mb-1"><?php echo $user['name']; ?></h4>
                        <p class="text-muted mb-2"><span class="badge bg-warning text-dark"><i class="fas fa-crown me-1"></i>Thành viên Vàng</span></p>
                        <p class="text-muted mb-4"><i class="fas fa-map-marker-alt me-2"></i>Hà Nội, Việt Nam</p>
                        
                        <div class="d-flex justify-content-center mb-2">
                            <button type="button" class="btn btn-primary me-2"><i class="fas fa-box-open me-1"></i> Đơn hàng</button>
                            <button type="button" class="btn btn-outline-danger"><i class="fas fa-heart me-1"></i> Yêu thích</button>
                        </div>
                    </div>
                </div>

                <!-- Thẻ thống kê tài khoản -->
                <div class="card mb-4">

                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-3">Thống kê mua sắm</h6>
                        <div>
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <span class="text-muted"><i class="fas fa-book text-primary me-2"></i>Sách đã mua</span>
                                <span class="fw-bold">42 cuốn</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <span class="text-muted"><i class="fas fa-star text-warning me-2"></i>Đánh giá</span>
                                <span class="fw-bold">15 lượt</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted"><i class="fas fa-coins text-success me-2"></i>Điểm tích lũy</span>
                                <span class="fw-bold">1,250 điểm</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Chi tiết và Cài đặt -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white pb-0 border-bottom-0 pt-3">
                        <ul class="nav nav-pills" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab"><i class="fas fa-info-circle me-1"></i> Thông tin</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="edit-tab" data-bs-toggle="pill" data-bs-target="#edit" type="button" role="tab"><i class="fas fa-user-edit me-1"></i> Cập nhật hồ sơ</button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content" id="profileTabContent">
                            
                            <!-- Tab Tổng quan -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                <h5 class="mb-4">Thông tin cá nhân</h5>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0 fw-bold">Họ và tên</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['name']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0 fw-bold">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['email']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0 fw-bold">Điện thoại</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['phone']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0 fw-bold">Địa chỉ</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['address']; ?></p>
                                    </div>
                                </div>
                                
                                <!-- Thay thế kỹ năng bằng lịch sử đơn hàng gần đây -->
                                <h5 class="mt-5 mb-3">Đơn hàng gần đây</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Mã ĐH</th>
                                                <th>Ngày mua</th>
                                                <th>Sản phẩm</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order) : ?>
                                            <tr>
                                                <td><a href="#" class="fw-bold text-decoration-none">#<?php echo $order['order_id']; ?></a></td>
                                                <td><?php echo $order['order_date']; ?></td>
                                                <td><?php echo $order['product_name']; ?></td>
                                                <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</td>
                                                <td><span class="badge bg-success">Đã giao</span></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Chỉnh sửa hồ sơ -->
                            <div class="tab-pane fade" id="edit" role="tabpanel">
                                <form>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Họ và tên</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" name="name" value="Nguyễn Văn A" placeholder="Nhập họ và tên của bạn">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" name="email" value="nguyenvana@example.com" placeholder="Nhập địa chỉ email">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Số điện thoại</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" name="phone" value="(084) 123-456-789" placeholder="Nhập số điện thoại">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Địa chỉ giao hàng</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <textarea class="form-control" name="address" rows="3" placeholder="Nhập địa chỉ nhận sách">Số 10, Đường Cầu Giấy, Hà Nội, Việt Nam</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-light me-2">Hủy</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer cung cấp bởi người dùng -->
    <footer class="bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <div>
                    <h4 class="text-white fw-bold h5 mb-3">BookStore</h4>
                    <p class="small">Nơi kết nối đam mê đọc sách và lan tỏa tri thức đến mọi người Việt Nam.</p>
                </div>
                <div>
                    <h4 class="text-white fw-bold h6 mb-3">Liên kết</h4>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Trang chủ</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Sách mới</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Khuyến mãi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white fw-bold h6 mb-3">Hỗ trợ</h4>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Chính sách vận chuyển</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Đổi trả hàng</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white fw-bold h6 mb-3">Đăng ký nhận tin</h4>
                    <div class="d-flex flex-column">    
                        <input type="email" class="form-control bg-secondary border-0 mb-2 small text-light" placeholder="Email của bạn">
                        <button class="btn btn-primary small fw-bold">Đăng ký</button>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-3 text-center small">
                <p class="mb-0">&copy; 2024 BookStore. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Nhúng Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.css"></script>
</body>
</html>