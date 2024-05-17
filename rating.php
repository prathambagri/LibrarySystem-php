<?php
// Function to submit a rating for a book
function submitRating($mysqli, $bookId, $rating, $userId) {
    // Check if the user has already rated the book
    $query = "SELECT * FROM book_ratings WHERE book_id = $bookId AND user_id = $userId";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        // Update existing rating
        $query = "UPDATE book_ratings SET rating = $rating WHERE book_id = $bookId AND user_id = $userId";
    } else {
        // Insert new rating
        $query = "INSERT INTO book_ratings (book_id, rating, user_id) VALUES ($bookId, $rating, $userId)";
    }

    if ($mysqli->query($query) === TRUE) {
        return true; // Rating submitted successfully
    } else {
        return false; // Failed to submit rating
    }
}

// Example usage:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST['BookId']; // ID of the book being rated
    $rating = $_POST['rating'];   // User's rating for the book
    $userId = 123;                // Example: ID of the user submitting the rating (you should get this from session or login)

    if (submitRating($mysqli, $bookId, $rating, $userId)) {
        echo "Rating submitted successfully.";
    } else {
        echo "Failed to submit rating.";
    }
}

// Close database connection
$mysqli->close();
?>
