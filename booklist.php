<?php
session_start();
include('db.php');

// Ensure the user is logged in
if ($_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all books from the database
$books_result = $conn->query("SELECT * FROM books");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_readlist'])) {
    $book_id = $_POST['book_id'];

    // Insert the book into the user's readlist
    $sql = "INSERT INTO readlist (user_id, book_id) VALUES ($user_id, $book_id)";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booklist - ReadRight</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Booklist</h1>
    </header>

    <nav>
        <a href="user_profile.php">Profile</a>
        <a href="booklist.php">Booklist</a>
        <a href="reviews.php">Reviews</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h2>All Available Books</h2>
        <ul>
            <?php while ($book = $books_result->fetch_assoc()) { ?>
                <li>
                    <!-- Display book thumbnail if available -->
                    <?php if ($book['thumbnail']) { ?>
                        <img src="<?php echo $book['thumbnail']; ?>" alt="Thumbnail" width="100" height="150">
                    <?php } else { ?>
                        <img src="default-thumbnail.jpg" alt="Default Thumbnail" width="100" height="150">
                    <?php } ?>

                    <?php echo $book['name']; ?> (<?php echo $book['genre']; ?>, <?php echo $book['writer']; ?>)

                    <!-- Add to readlist form -->
                     <img src="bleak.jpeg" alt="Thumbnail" width="100" height="150">
                     Bleak House (Mystery, Charles Dickens)

                     <img src="hamlet.jpeg" alt="Thumbnail" width="100" height="150">
                     Hamlet (Tragedy, William shakespeare )

                     <img src="invisible.jpeg" alt="Thumbnail" width="100" height="150">
                     Invisible Man (Social Commentary, Ralph Ellison)

                     <img src="jane.jpeg" alt="Thumbnail" width="100" height="150">
                     Jane Eyre (Romance, Charlotte Brontes)

                     <img src="pride.jpeg" alt="Thumbnail" width="100" height="150">
                     Pride and Prejudice (Romance, Jane Austen)

                     <img src="trial.jpeg" alt="Thumbnail" width="100" height="150">
                     The Trial (Crime Thriller, Franz Kafka)

                     <img src="war&peace.jpeg" alt="Thumbnail" width="100" height="150">
                     War and Peace (Historical, Leo Tolstoy)

                     <img src="wrath.jpeg" alt="Thumbnail" width="100" height="150">
                     The Grapes of Wrath (Realist Fiction, Jhon Steinbeck)
                     
                     <img src="expectations.jpeg" alt="Thumbnail" width="100" height="150">
                     Great Expectations (Social Criticism, Charles Dickens)
                    
                    

                    

                    
                    <form method="POST" action="booklist.php" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <button type="submit" name="add_to_readlist">Add to Readlist</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
