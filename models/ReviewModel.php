<?php

class ReviewModel extends BaseModel
{
    protected $table = 'reviews';

    /**
     * Lấy danh sách reviews của sách (chỉ approved mặc định)
     * @param int $book_id - ID sách
     * @param bool $approved_only - Chỉ lấy reviews approved
     * @return array - Danh sách reviews
     */
    public function getReviewsByBookId($book_id, $approved_only = true)
    {
        $sql = "SELECT r.*, u.name as user_name 
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                WHERE r.book_id = :book_id";

        if ($approved_only) {
            $sql .= " AND r.status = 'approved'";
        }

        $sql .= " ORDER BY r.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':book_id' => $book_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy chi tiết 1 review
     * @param int $review_id - ID review
     * @return array - Chi tiết review
     */
    public function getReviewById($review_id)
    {
        $sql = "SELECT r.*, u.name as user_name, b.title as book_title
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                JOIN books b ON r.book_id = b.book_id
                WHERE r.review_id = :review_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':review_id' => $review_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm review mới
     * @param int $book_id - ID sách
     * @param int $user_id - ID user
     * @param int $rating - Đánh giá (1-5)
     * @param string $comment - Bình luận (optional)
     * @return int|false - ID review mới hoặc false nếu thất bại
     */
    public function addReview($book_id, $user_id, $rating, $comment = '')
    {
        // Validate rating
        if ($rating < 1 || $rating > 5) {
            return false;
        }

        $sql = "INSERT INTO reviews (book_id, user_id, rating, comment, status, created_at) 
                VALUES (:book_id, :user_id, :rating, :comment, 'approved', NOW())";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':book_id' => $book_id,
            ':user_id' => $user_id,
            ':rating' => $rating,
            ':comment' => $comment
        ]);

        if ($result) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Cập nhật status của review (approve/reject/...)
     * @param int $review_id - ID review
     * @param string $status - Status mới (pending/approved/rejected)
     * @return bool
     */
    public function updateReviewStatus($review_id, $status)
    {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return false;
        }

        $sql = "UPDATE reviews 
                SET status = :status, updated_at = NOW()
                WHERE review_id = :review_id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':review_id' => $review_id,
            ':status' => $status
        ]);
    }

    /**
     * Xóa review
     * @param int $review_id - ID review
     * @return bool
     */
    public function deleteReview($review_id)
    {
        $sql = "DELETE FROM reviews WHERE review_id = :review_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':review_id' => $review_id]);
    }

    /**
     * Kiểm tra user có thể review sách không (phải đã mua sách)
     * @param int $book_id - ID sách
     * @param int $user_id - ID user
     * @return bool
     */
    public function userCanReview($book_id, $user_id)
    {
        // Kiểm tra user đã mua sách chưa (có order đã delivered/completed)
        $sql = "SELECT COUNT(*) as count
                FROM order_detail od
                JOIN orders o ON od.order_id = o.order_id
                JOIN book_variants bv ON od.variant_id = bv.variant_id
                WHERE bv.book_id = :book_id 
                AND o.user_id = :user_id 
                AND o.status IN ('completed', 'delivered')";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':book_id' => $book_id,
            ':user_id' => $user_id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && $result['count'] > 0;
    }

    /**
     * Kiểm tra user đã review sách này chưa
     * @param int $book_id - ID sách
     * @param int $user_id - ID user
     * @return bool
     */
    public function userHasReviewed($book_id, $user_id)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM reviews 
                WHERE book_id = :book_id AND user_id = :user_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':book_id' => $book_id,
            ':user_id' => $user_id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && $result['count'] > 0;
    }

    /**
     * Lấy rating trung bình của sách
     * @param int $book_id - ID sách
     * @return float
     */
    public function getAverageRating($book_id)
    {
        $sql = "SELECT ROUND(AVG(rating), 2) as average
                FROM reviews 
                WHERE book_id = :book_id AND status = 'approved'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':book_id' => $book_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && $result['average'] !== null ? (float)$result['average'] : 0;
    }

    /**
     * Đếm số reviews (chỉ approved mặc định)
     * @param int $book_id - ID sách
     * @param bool $approved_only - Chỉ đếm approved
     * @return int
     */
    public function getReviewCount($book_id, $approved_only = true)
    {
        $sql = "SELECT COUNT(*) as count FROM reviews WHERE book_id = :book_id";

        if ($approved_only) {
            $sql .= " AND status = 'approved'";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':book_id' => $book_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Lấy danh sách reviews chờ duyệt (admin)
     * @param int $limit - Giới hạn số rows
     * @param int $offset - Offset
     * @return array
     */
    public function getAllReviewsPending($limit = 20, $offset = 0)
    {
        $sql = "SELECT r.*, u.name as user_name, b.title as book_title
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                JOIN books b ON r.book_id = b.book_id
                WHERE r.status = 'pending'
                ORDER BY r.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách tất cả reviews (admin)
     * @param string $status - Filter by status (all/pending/approved/rejected)
     * @param int $limit - Giới hạn số rows
     * @param int $offset - Offset
     * @return array
     */
    public function getAllReviews($status = 'all', $limit = 20, $offset = 0)
    {
        $sql = "SELECT r.*, u.name as user_name, b.title as book_title
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                JOIN books b ON r.book_id = b.book_id";

        if ($status !== 'all') {
            $sql .= " WHERE r.status = :status";
        }

        $sql .= " ORDER BY r.created_at DESC
                 LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if ($status !== 'all') {
            $stmt->bindValue(':status', $status);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tất cả reviews (admin)
     * @param string $status - Filter by status
     * @return int
     */
    public function countAllReviews($status = 'all')
    {
        $sql = "SELECT COUNT(*) as count FROM reviews";

        if ($status !== 'all') {
            $sql .= " WHERE status = :status";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($status !== 'all') {
            $stmt->bindValue(':status', $status);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Lấy reviews của user (cho profile)
     * @param int $user_id - ID user
     * @return array
     */
    public function getUserReviews($user_id)
    {
        $sql = "SELECT r.*, b.title as book_title, b.image
                FROM reviews r
                JOIN books b ON r.book_id = b.book_id
                WHERE r.user_id = :user_id
                ORDER BY r.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
