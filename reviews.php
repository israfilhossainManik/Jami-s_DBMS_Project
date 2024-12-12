<?php
session_start();
include('db.php');

// Ensure the user is logged in
if ($_SESSION['role'] != 'user' && $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Get all reviews submitted by users, including ratings
$reviews_result = $conn->query("SELECT reviews.review_text, reviews.rating, books.name AS book_name, users.username 
                                 FROM reviews
                                 JOIN books ON reviews.book_id = books.id
                                 JOIN users ON reviews.user_id = users.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reviews - ReadRight</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS for displaying star ratings */
        .star-rating {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .review-item {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>All Reviews</h1>
    </header>

    <nav>
        <a href="user_profile.php">Profile</a>
        <a href="booklist.php">Booklist</a>
        <a href="reviews.php">Reviews</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h3>All Reviews</h3>
        <ul>
            <?php while ($review = $reviews_result->fetch_assoc()) { ?>
                <li class="review-item">
                    <strong><?php echo htmlspecialchars($review['username']); ?>:</strong>
                    <p><?php echo htmlspecialchars($review['review_text']); ?></p>
                    <p>Book: <em><?php echo htmlspecialchars($review['book_name']); ?></em></p>
                    <p class="star-rating">
                        Rating: <?php echo str_repeat("&#9733;", $review['rating']); ?>
                        <?php echo str_repeat("&#9734;", 5 - $review['rating']); ?>
                    </p>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
