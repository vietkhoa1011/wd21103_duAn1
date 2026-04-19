<?php

require_once __DIR__ . '/../../models/ReviewModel.php';
require_once __DIR__ . '/../../models/AuthModel.php';

class ReviewAdminController
{
    public $reviewModel;
    public $authModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->authModel = new AuthModel();
    }

    /**
     * Danh sách reviews (admin panel)
     */
    public function listReviews()
    {
        // Kiểm tra quyền admin
        $this->authModel->checkAdmin();

        $status = $_GET['status'] ?? 'all';
        $page = (int)($_GET['page'] ?? 1);
        $page = max(1, $page);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        try {
            $reviews = $this->reviewModel->getAllReviews($status, $limit, $offset);
            $total = $this->reviewModel->countAllReviews($status);
            $total_pages = ceil($total / $limit);

            require_once PATH_VIEW . 'admin/review/review.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
            header('Location: index.php?action=/book');
            exit;
        }
    }

    /**
     * Phê duyệt review
     */
    public function approveReview()
    {
        // Kiểm tra quyền admin
        $this->authModel->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Method không được hỗ trợ';
            header('Location: index.php?action=/admin/review');
            exit;
        }

        $review_id = (int)($_POST['review_id'] ?? 0);

        if ($review_id <= 0) {
            $_SESSION['error'] = 'ID review không hợp lệ';
            header('Location: index.php?action=/admin/review');
            exit;
        }

        try {
            $review = $this->reviewModel->getReviewById($review_id);
            
            if (!$review) {
                $_SESSION['error'] = 'Review không tồn tại';
                header('Location: index.php?action=/admin/review');
                exit;
            }

            if ($this->reviewModel->updateReviewStatus($review_id, 'approved')) {
                $_SESSION['success'] = 'Phê duyệt review thành công';
            } else {
                $_SESSION['error'] = 'Lỗi khi phê duyệt review';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }

        header('Location: index.php?action=/admin/review');
        exit;
    }

    /**
     * Từ chối review
     */
    public function rejectReview()
    {
        // Kiểm tra quyền admin
        $this->authModel->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Method không được hỗ trợ';
            header('Location: index.php?action=/admin/review');
            exit;
        }

        $review_id = (int)($_POST['review_id'] ?? 0);

        if ($review_id <= 0) {
            $_SESSION['error'] = 'ID review không hợp lệ';
            header('Location: index.php?action=/admin/review');
            exit;
        }

        try {
            $review = $this->reviewModel->getReviewById($review_id);
            
            if (!$review) {
                $_SESSION['error'] = 'Review không tồn tại';
                header('Location: index.php?action=/admin/review');
                exit;
            }

            if ($this->reviewModel->updateReviewStatus($review_id, 'rejected')) {
                $_SESSION['success'] = 'Từ chối review thành công';
            } else {
                $_SESSION['error'] = 'Lỗi khi từ chối review';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }

        header('Location: index.php?action=/admin/review');
        exit;
    }

    /**
     * Xóa review
     */
    public function deleteReview()
    {
        // Kiểm tra quyền admin
        $this->authModel->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Method không được hỗ trợ';
            header('Location: index.php?action=/admin/review');
            exit;
        }

        $review_id = (int)($_POST['review_id'] ?? 0);

        if ($review_id <= 0) {
            $_SESSION['error'] = 'ID review không hợp lệ';
            header('Location: index.php?action=/admin/review');
            exit;
        }

        try {
            $review = $this->reviewModel->getReviewById($review_id);
            
            if (!$review) {
                $_SESSION['error'] = 'Review không tồn tại';
                header('Location: index.php?action=/admin/review');
                exit;
            }

            if ($this->reviewModel->deleteReview($review_id)) {
                $_SESSION['success'] = 'Xóa review thành công';
            } else {
                $_SESSION['error'] = 'Lỗi khi xóa review';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }

        header('Location: index.php?action=/admin/review');
        exit;
    }
}
