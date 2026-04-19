<?php

/**
 * Partial View: Review List
 * Hiển thị danh sách reviews (chỉ approved)
 * Variables: $book_id, $reviews, $average_rating, $review_count
 */
if (!isset($reviews)) {
    $reviews = [];
}
?>

<div class="reviews-list-section">
    <div class="detail-card">
        <h5 class="fw-bold mb-4"><i class="fas fa-comments text-primary me-2"></i>Đánh giá từ bạn đọc</h5>

        <!-- Rating Summary -->
        <div class="rating-summary mb-5 p-4 rounded-4" style="background: linear-gradient(135deg, #eef2ff 0%, #f0f4ff 100%);">
            <div class="row align-items-center">
                <div class="col-md-4 text-center border-end">
                    <div class="display-5 fw-bold text-primary mb-2">
                        <?= htmlspecialchars(number_format($average_rating, 1)) ?>
                    </div>
                    <div class="stars-display mb-2">
                        <?php
                        $fullStars = floor($average_rating);
                        $hasHalfStar = ($average_rating - $fullStars) >= 0.5;
                        for ($i = 0; $i < $fullStars; $i++):
                        ?>
                            <i class="fas fa-star" style="color: #fbbf24; margin-right: 2px;"></i>
                        <?php endfor; ?>
                        <?php if ($hasHalfStar): ?>
                            <i class="fas fa-star-half-alt" style="color: #fbbf24; margin-right: 2px;"></i>
                            <?php $i++; ?>
                        <?php endif; ?>
                        <?php while ($i < 5): ?>
                            <i class="far fa-star" style="color: #cbd5e1; margin-right: 2px;"></i>
                            <?php $i++; ?>
                        <?php endwhile; ?>
                    </div>
                    <small class="text-muted">Dựa trên <?= htmlspecialchars(count($reviews)) ?> đánh giá</small>
                </div>
                <div class="col-md-8">
                    <!-- Rating breakdown (optional - simple version) -->
                    <div class="rating-breakdown-simple">
                        <?php
                        // Tính toán số reviews cho mỗi rating
                        $reviews_by_rating = array_fill(1, 5, 0);
                        foreach ($reviews as $review) {
                            $reviews_by_rating[$review['rating']]++;
                        }
                        $total_displayed_reviews = count($reviews);

                        for ($stars = 5; $stars >= 1; $stars--):
                            $count = $reviews_by_rating[$stars];
                            $percentage = $total_displayed_reviews > 0 ? ($count / $total_displayed_reviews) * 100 : 0;
                        ?>
                            <div class="d-flex align-items-center mb-2">
                                <small class="text-muted me-2" style="width: 40px;"><?= $stars ?> <i class="fas fa-star" style="color: #fbbf24;"></i></small>
                                <div class="progress flex-grow-1" style="height: 6px; background: #e2e8f0;">
                                    <div class="progress-bar" style="width: <?= $percentage ?>%; background: linear-gradient(90deg, #4f46e5, #6366f1);"></div>
                                </div>
                                <small class="text-muted ms-2" style="width: 30px; text-align: right;"><?= (int)$count ?></small>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <?php if (!empty($reviews)): ?>
            <div class="reviews-container">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item border-bottom py-4">
                        <div class="row">
                            <div class="col-12">
                                <!-- Review Header -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($review['user_name']) ?></h6>
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?>
                                        </small>
                                    </div>
                                    <div class="stars-display">
                                        <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                            <i class="fas fa-star" style="color: #fbbf24; font-size: 0.9rem;"></i>
                                        <?php endfor; ?>
                                        <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                                            <i class="far fa-star" style="color: #cbd5e1; font-size: 0.9rem;"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>

                                <!-- Review Comment -->
                                <?php if (!empty($review['comment'])): ?>
                                    <p class="mt-3 mb-0 text-muted" style="line-height: 1.6;">
                                        <?= nl2br(htmlspecialchars($review['comment'])) ?>
                                    </p>
                                <?php else: ?>
                                    <p class="mt-3 mb-0 text-muted" style="font-style: italic;">
                                        (Không có bình luận)
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert bg-light border-0 rounded-4 p-4 text-center">
                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                <p class="mb-0 text-muted">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá cuốn sách này!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .review-item {
        transition: background-color 0.2s ease;
    }

    .review-item:hover {
        background-color: #f8fafc;
    }

    .stars-display {
        display: inline-flex;
        gap: 2px;
    }

    .rating-breakdown-simple .progress-bar {
        transition: width 0.3s ease;
    }
</style>