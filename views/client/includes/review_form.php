<?php
$book_id = $book_id ?? ($book['book_id'] ?? 0);
?>

<?php if (isset($user_can_review) && $user_can_review): ?>
    <div class="review-form-section mb-5">
        <div class="detail-card">
            <h5 class="fw-bold mb-4"><i class="fas fa-pen-fancy text-primary me-2"></i>Đánh giá sách</h5>

            <?php if (isset($user_has_reviewed) && $user_has_reviewed): ?>
                <div class="alert alert-info border-0 rounded-4 p-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Bạn đã đánh giá sách này rồi. Mỗi người dùng chỉ có thể review một sách một lần.
                </div>
            <?php else: ?>
                <form id="reviewForm" class="review-form">
                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book_id) ?>">

                    <!-- Rating Section -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">Đánh giá (1-5 sao)</label>
                        <div class="rating-stars d-flex gap-2" id="ratingStars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="star-wrapper">
                                    <input
                                        type="radio"
                                        name="rating"
                                        id="rating-<?= $i ?>"
                                        value="<?= $i ?>"
                                        class="star-input"
                                        required />
                                    <label for="rating-<?= $i ?>" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <div id="ratingValue" class="mt-2 text-muted" style="display: none;">
                            <small>Bạn đã chọn <span id="selectedRating">0</span> sao</small>
                        </div>
                    </div>

                    <!-- Comment Section -->
                    <div class="mb-4">
                        <label for="comment" class="form-label fw-semibold">Bình luận (tùy chọn)</label>
                        <textarea
                            id="comment"
                            name="comment"
                            class="form-control rounded-3"
                            rows="4"
                            placeholder="Chia sẻ cảm nhận của bạn về cuốn sách này..."
                            maxlength="5000"></textarea>
                        <small class="text-muted">Tối đa 5000 ký tự. <span id="charCount">0</span>/5000</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary-gradient" id="submitReview">
                        <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                    </button>
                </form>

                <!-- Success Message -->
                <div id="successMessage" class="alert alert-success border-0 rounded-4 p-4" style="display: none; margin-top: 1.5rem;">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Thành công!</strong> Đánh giá của bạn đã được hiển thị trên trang.
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="alert alert-danger border-0 rounded-4 p-4" style="display: none; margin-top: 1.5rem;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Lỗi!</strong> <span id="errorText"></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        /* Star rating styling */
        .rating-stars {
            font-size: 2.5rem;
        }

        .star-wrapper {
            position: relative;
        }

        .star-input {
            display: none;
        }

        .star-label {
            cursor: pointer;
            color: #cbd5e1;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            margin: 0;
        }

        .star-input:checked~.star-label,
        .star-input:hover~.star-label {
            color: #fbbf24;
            transform: scale(1.15);
        }

        /* Hover effect - highlight all previous stars */
        .star-wrapper:hover .star-label {
            color: #fbbf24;
        }

        .star-wrapper:hover~.star-wrapper .star-label {
            color: #cbd5e1;
        }
    </style>

    <script>
        // Manage rating display
        const ratingInputs = document.querySelectorAll('.star-input');
        const selectedRatingSpan = document.getElementById('selectedRating');
        const ratingValue = document.getElementById('ratingValue');

        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                selectedRatingSpan.textContent = this.value;
                ratingValue.style.display = 'block';
            });
        });

        // Character counter
        const commentInput = document.getElementById('comment');
        const charCount = document.getElementById('charCount');

        commentInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        // Form submission
        const reviewForm = document.getElementById('reviewForm');
        const submitBtn = document.getElementById('submitReview');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');

        reviewForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const rating = document.querySelector('input[name="rating"]:checked').value;
            const comment = commentInput.value;
            const bookId = document.querySelector('input[name="book_id"]').value;

            // Disable button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';

            try {
                const response = await fetch('index.php?action=/review/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        book_id: bookId,
                        rating: rating,
                        comment: comment
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    successMessage.style.display = 'block';
                    errorMessage.style.display = 'none';
                    reviewForm.style.display = 'none';

                    // Scroll to success message
                    successMessage.scrollIntoView({
                        behavior: 'smooth'
                    });

                    // Reload reviews after 2 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    errorText.textContent = data.message || 'Có lỗi xảy ra';
                    errorMessage.style.display = 'block';
                    successMessage.style.display = 'none';
                    errorMessage.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                errorText.textContent = 'Lỗi kết nối. Vui lòng thử lại.';
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
            } finally {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Gửi đánh giá';
            }
        });
    </script>

<?php else: ?>
    <div class="detail-card mb-5 overflow-hidden">
        <div class="alert alert-warning border-0 rounded-4 p-3 p-md-4">
            <div class="d-flex align-items-start">
                <i class="fas fa-lock mt-1 me-2"></i>
                <div>
                    <strong>Không thể review</strong> - Bạn cần
                    <?php
                    if (!isset($_SESSION['user'])):
                        echo '<a href="index.php?action=/login" class="alert-link">đăng nhập</a>';
                    else:
                        echo 'mua cuốn sách này';
                    endif;
                    ?> để có thể đánh giá.
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>