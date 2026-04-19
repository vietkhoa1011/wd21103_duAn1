<?php

require_once __DIR__ . '/../../models/ReviewModel.php';

class ReviewController
{
    public $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    /**
     * Thêm review (POST request)
     */
    public function addReview()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Method không được hỗ trợ']);
            return;
        }

        // Kiểm tra user đã đăng nhập
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để review']);
            return;
        }

        $book_id = (int)($_POST['book_id'] ?? 0);
        $user_id = (int)$_SESSION['user']['user_id'];
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        // Validate input
        if ($book_id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID sách không hợp lệ']);
            return;
        }

        if ($rating < 1 || $rating > 5) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Đánh giá phải từ 1-5 sao']);
            return;
        }

        if (strlen($comment) > 5000) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bình luận quá dài (tối đa 5000 ký tự)']);
            return;
        }

        // Kiểm tra user có mua sách không
        if (!$this->reviewModel->userCanReview($book_id, $user_id)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Bạn phải mua sách này để có thể review']);
            return;
        }

        // Kiểm tra user đã review sách này chưa
        if ($this->reviewModel->userHasReviewed($book_id, $user_id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bạn đã review sách này rồi']);
            return;
        }

        // Thêm review
        try {
            $review_id = $this->reviewModel->addReview($book_id, $user_id, $rating, $comment);
            
            if ($review_id) {
                http_response_code(201);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Review của bạn đã gửi thành công. Chờ admin duyệt.',
                    'review_id' => $review_id
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Lỗi khi thêm review']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    /**
     * Lấy danh sách reviews của sách (AJAX request)
     */
    public function getReviewsForBook()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Method không được hỗ trợ']);
            return;
        }

        $book_id = (int)($_GET['book_id'] ?? 0);

        if ($book_id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID sách không hợp lệ']);
            return;
        }

        try {
            $reviews = $this->reviewModel->getReviewsByBookId($book_id, true);
            $average_rating = $this->reviewModel->getAverageRating($book_id);
            $review_count = $this->reviewModel->getReviewCount($book_id, true);

            // Sanitize comment
            foreach ($reviews as &$review) {
                $review['comment'] = htmlspecialchars($review['comment']);
                $review['user_name'] = htmlspecialchars($review['user_name']);
            }

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => [
                    'reviews' => $reviews,
                    'average_rating' => $average_rating,
                    'review_count' => $review_count
                ]
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }
}
