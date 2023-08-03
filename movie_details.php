<!DOCTYPE html>
<html>
<head>
    <title>Movie Details</title>
    <style>
        /* Add your preferred styles for the movie details page here */
        /* ... */
    </style>
</head>
<body>
    <h1>Movie Details</h1>

    <?php
    $server = "127.0.0.1";
    $user = "ahmad";
    $password = "ahmad";
    $datenbank = "ods_db";

    $mysqli = new mysqli($server, $user, $password, $datenbank);

    // Check for database connection errors
    if ($mysqli->connect_errno) {
        die("Database connection failed: " . $mysqli->connect_error);
    }

    // Check if the movie parameter is set in the URL
    if (isset($_GET['movie']) && !empty($_GET['movie'])) {
        $search_query = $_GET['movie'];
        $column_name = "Series_Title";

        // Sanitize the search query to prevent SQL injection
        $search_query = $mysqli->real_escape_string($search_query);

        // Prepare the SQL query to get the details of the selected movie
        $query = "SELECT * FROM tabelle1 WHERE $column_name = '$search_query'";

        // Execute the query
        $result = $mysqli->query($query);

        // Handle the query result
        if ($result && $result->num_rows > 0) {
            $movie_details = $result->fetch_assoc();
            echo '<div class="movie-box">';
            echo '<div class="movie-poster"><img src="' . $movie_details['Poster_Link'] . '" alt="' . $movie_details['Series_Title'] . ' Poster"></div>';
            echo '<div class="movie-info">';
            echo '<div class="movie-title">' . $movie_details['Series_Title'] . '</div>';
            echo '<div class="movie-details">Release Year: ' . $movie_details['Released_Year'] . '</div>';
            echo '<div class="movie-details">Run Time: ' . $movie_details['Runtime'] . '</div>';
            echo '<div class="movie-details">Genre: ' . $movie_details['Genre'] . '</div>';
            echo '<div class="movie-details">Stars: ';
            // Add hyperlink to the star names
            echo '<a href="movies_by_star_director.php?star=' . urlencode($movie_details['Star1']) . '">' . $movie_details['Star1'] . '</a>';
            if (!empty($movie_details['Star2'])) {
                echo ', <a href="movies_by_star_director.php?star=' . urlencode($movie_details['Star2']) . '">' . $movie_details['Star2'] . '</a>';
            }
            if (!empty($movie_details['Star3'])) {
                echo ', <a href="movies_by_star_director.php?star=' . urlencode($movie_details['Star3']) . '">' . $movie_details['Star3'] . '</a>';
            }
            if (!empty($movie_details['Star4'])) {
                echo ', <a href="movies_by_star_director.php?star=' . urlencode($movie_details['Star4']) . '">' . $movie_details['Star4'] . '</a>';
            }
            echo '</div>';
            // Add hyperlink to the director's name
            echo '<div class="movie-details">Director: <a href="movies_by_star_director.php?director=' . urlencode($movie_details['Director']) . '">' . $movie_details['Director'] . '</a></div>';
            echo '<div class="movie-details">IMDb Rating: ' . $movie_details['IMDB_Rating'] . '</div>';
            // Add more movie information as needed
            echo '</div>';
            echo '</div>';
        } else {
            echo "<p>Movie not found.</p>";
        }
        // Free the result set
        $result->free();
    } else {
        echo "<p>Invalid movie parameter.</p>";
    }

    // Close the database connection
    $mysqli->close();
    ?>

</body>
</html>
