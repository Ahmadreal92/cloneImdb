<!DOCTYPE html>
<html>

<head>
    <title>Movies By Genre</title>
    <style>
        /* Add your preferred styles for the movies list here */
        .movie-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .movie-title {
            font-size: 18px;
            font-weight: bold;
        }

        .movie-details {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .movie-poster {
            max-width: 150px;
        }

        .movie-poster img {
            max-width: 100%;
            height: auto;
        }

        /* Add styles for the black line */
        hr {
            border: none;
            height: 2px;
            background-color: #000;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <h2>Movies By Genre:</h2>
    <form action="search_results.php" method="GET">
        <label for="search_query">Search for a movie:</label>
        <input type="text" id="search_query" name="q" required>
        <input type="submit" value="Search">
    </form>

    <hr> <!-- Black line after the search bar -->

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

    // Check if the genre parameter is set in the URL
    if (isset($_GET['genre']) && !empty($_GET['genre'])) {
        $selected_genre = $_GET['genre'];

        // Sanitize the selected genre to prevent SQL injection
        $selected_genre = $mysqli->real_escape_string($selected_genre);

        // Prepare the SQL query for the selected genre
        $query = "SELECT * FROM tabelle1 WHERE Genre LIKE '%$selected_genre%'";

        // Execute the query
        $result = $mysqli->query($query);

        // Handle the query result
        if ($result) {
            if ($result->num_rows > 0) {
                echo "<h2>Movies in the Genre: $selected_genre</h2>";
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="movie-box">';
                    echo '<div class="movie-poster"><img src="' . $row['Poster_Link'] . '" alt="' . $row['Series_Title'] . ' Poster"></div>';
                    echo '<div class="movie-info">';
                    echo '<div class="movie-title">' . $row['Series_Title'] . '</div>';
                    echo '<div class="movie-details">Release Year: ' . $row['Released_Year'] . '</div>';
                    echo '<div class="movie-details">Run Time: ' . $row['Runtime'] . '</div>';
                    echo '<div class="movie-details">IMDB: ' . $row['IMDB_Rating'] . '</div>';
                    echo '<div class="movie-details">Genre: <a href="movies_by_genre.php?genre=' . urlencode($row['Genre']) . '">' . $row['Genre'] . '</a></div>';
                    echo '<div class="movie-details">Stars: ';
                    echo '<a href="movies_by_star_director.php?star=' . urlencode($row['Star1']) . '">' . $row['Star1'] . '</a>, ';
                    echo '<a href="movies_by_star_director.php?star=' . urlencode($row['Star2']) . '">' . $row['Star2'] . '</a>, ';
                    echo '<a href="movies_by_star_director.php?star=' . urlencode($row['Star3']) . '">' . $row['Star3'] . '</a>, ';
                    echo '<a href="movies_by_star_director.php?star=' . urlencode($row['Star4']) . '">' . $row['Star4'] . '</a>';
                    echo '</div>';
                    echo '<div class="movie-details">Director: <a href="movies_by_star_director.php?director=' . urlencode($row['Director']) . '">' . $row['Director'] . '</a></div>';
                    // Add more movie information as needed
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>No movies found in the genre: $selected_genre.</p>";
            }
            // Free the result set
            $result->free();
        } else {
            // Handle the query error
            echo "Error executing the query: " . $mysqli->error;
        }
    }

    // Close the database connection
    $mysqli->close();
    ?>
</body>

</html>
