<!DOCTYPE html>
<html>
<head>
    <title>Movie Search</title>
    <style>
        /* Add your preferred styles here */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f2f2f2;
        }

        .search-container {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .search-form {
            display: inline-block;
            padding: 10px;
            border: 2px solid #f2f2f2;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .search-form label {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ff8c00;
            border-radius: 5px;
            width: 300px;
            max-width: 100%;
            margin-right: 10px;
            text-align: center;
        }

        .search-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #ff8c00;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #ff9632;
        }

        /* Add your preferred styles for the tables */
        .movie-table {
            border-collapse: collapse;
            width: 45%;
            table-layout: fixed;
            margin: 10px;
        }

        .movie-table th,
        .movie-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .movie-table th {
            background-color: #f2f2f2;
        }

        .movie-table td {
            max-width: 200px;
            word-wrap: break-word;
        }

        .container-table {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="search-container">
        <h1>Movie Search</h1>
        <div class="search-form">
            <form action="search_results.php" method="GET">
                <label for="search_query">Search for a movie, Stars or Director:</label>
                <input type="text" id="search_query" name="q" required>
                <button type="submit">Search</button>
            </form>
        </div>
    

    <hr> <!-- Black line after the search bar -->

   <h2>Editor's Choice:</h2>
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

    // Display "Editor's Choice" with a random movie
    $random_query = "SELECT * FROM tabelle1 ORDER BY RAND() LIMIT 1";
    $random_result = $mysqli->query($random_query);

    if ($random_result && $random_result->num_rows > 0) {
        $random_row = $random_result->fetch_assoc();
        echo '<div class="movie-box">';
        echo '<div class="movie-poster"><img src="' . $random_row['Poster_Link'] . '" alt="' . $random_row['Series_Title'] . ' Poster"></div>';
        echo '<div class="movie-info">';
        // Add hyperlink to the movie name
        echo '<div class="movie-title"><a href="movie_details.php?movie=' . urlencode($random_row['Series_Title']) . '">' . $random_row['Series_Title'] . '</a></div>';
        echo '<div class="movie-details">Release Year: ' . $random_row['Released_Year'] . '</div>';
        echo '<div class="movie-details">Run Time: ' . $random_row['Runtime'] . '</div>';
        echo '<div class="movie-details">IMDB Rating: ' . $random_row['IMDB_Rating'] . '</div>';
        echo '<div class="movie-details">Overview: ' . $random_row['Overview'] . '</div>';
        echo '<div class="movie-details">Genre: <a href="movies_by_genre.php?genre=' . urlencode($random_row['Genre']) . '">' . $random_row['Genre'] . '</a></div>';
        echo '<div class="movie-details">Stars: ';
        echo '<a href="movies_by_star_director.php?star=' . urlencode($random_row['Star1']) . '">' . $random_row['Star1'] . '</a>, ';
        echo '<a href="movies_by_star_director.php?star=' . urlencode($random_row['Star2']) . '">' . $random_row['Star2'] . '</a>, ';
        echo '<a href="movies_by_star_director.php?star=' . urlencode($random_row['Star3']) . '">' . $random_row['Star3'] . '</a>, ';
        echo '<a href="movies_by_star_director.php?star=' . urlencode($random_row['Star4']) . '">' . $random_row['Star4'] . '</a>';
        echo '</div>';
        // Add hyperlink to the director's name
        echo '<div class="movie-details">Director: <a href="movies_by_star_director.php?director=' . urlencode($random_row['Director']) . '">' . $random_row['Director'] . '</a></div>';
        // Add more movie information as needed
        echo '</div>';
        echo '</div>';
    } else {
        echo "<p>No random movie found.</p>";
    }

    // Close the result set for the "Editor's Choice" query
    $random_result->free();
    ?>
    <hr> <!-- Black line after the Editor's Choice -->
    <div class="container-table">
        <!-- Best Movies in Genre Comedy -->
        <table class="movie-table">
            <tr>
                <th colspan="2">Best Movies in Genre Comedy</th>
            </tr>
           <?php
    // Prepare the SQL query to get the best 5 films in Genre Comedy
    $query_comedy = "SELECT Series_Title FROM tabelle1 WHERE Genre LIKE '%Comedy%' ORDER BY IMDB_Rating DESC LIMIT 5";

    // Execute the query
    $result_comedy = $mysqli->query($query_comedy);

    // Handle the query result for best movies in Comedy genre
    if ($result_comedy && $result_comedy->num_rows > 0) {
        echo '<table class="movie-table">';
        echo '<colgroup>';
        echo '<col style="width: 100%">';
        echo '</colgroup>';
        echo '<tr><th>Movie</th></tr>';
        while ($row_comedy = $result_comedy->fetch_assoc()) {
            // Add hyperlink to the movie name
            echo '<tr><td><a href="movie_details.php?movie=' . urlencode($row_comedy['Series_Title']) . '">' . $row_comedy['Series_Title'] . '</a></td></tr>';
        }
        echo '</table>';
        $result_comedy->free();
    } else {
        echo "<p>No movies found in the Comedy genre.</p>";
    }
    ?>
        </table>

        <!-- Best Movies in Genre Drama -->
        <table class="movie-table">
            <tr>
                <th colspan="2">Best Movies in Genre Drama</th>
            </tr>
             <?php
    // Prepare the SQL query to get the best 5 films in Genre Drama
    $query_drama = "SELECT Series_Title FROM tabelle1 WHERE Genre LIKE '%Drama%' ORDER BY IMDB_Rating DESC LIMIT 5";

    // Execute the query
    $result_drama = $mysqli->query($query_drama);

    // Handle the query result for best movies in Drama genre
    if ($result_drama && $result_drama->num_rows > 0) {
        echo '<table class="movie-table">';
        echo '<colgroup>';
        echo '<col style="width: 100%">';
        echo '</colgroup>';
        echo '<tr><th>Movie</th></tr>';
        while ($row_drama = $result_drama->fetch_assoc()) {
            // Add hyperlink to the movie name
            echo '<tr><td><a href="movie_details.php?movie=' . urlencode($row_drama['Series_Title']) . '">' . $row_drama['Series_Title'] . '</a></td></tr>';
        }
        echo '</table>';
        $result_drama->free();
    } else {
        echo "<p>No movies found in the Drama genre.</p>";
    }
    ?>
        </table>
    </div>

    <div class="container-table">
        <!-- Best Movies in Genre Action -->
        <table class="movie-table">
            <tr>
                <th colspan="2">Best Movies in Genre Action</th>
            </tr>
            <?php
    // Prepare the SQL query to get the best 5 films in Genre Action
    $query_action = "SELECT Series_Title FROM tabelle1 WHERE Genre LIKE '%Action%' ORDER BY IMDB_Rating DESC LIMIT 5";

    // Execute the query
    $result_action = $mysqli->query($query_action);

    // Handle the query result for best movies in Action genre
    if ($result_action && $result_action->num_rows > 0) {
        echo '<table class="movie-table">';
        echo '<colgroup>';
        echo '<col style="width: 100%">';
        echo '</colgroup>';
        echo '<tr><th>Movie</th></tr>';
        while ($row_action = $result_action->fetch_assoc()) {
            // Add hyperlink to the movie name
            echo '<tr><td><a href="movie_details.php?movie=' . urlencode($row_action['Series_Title']) . '">' . $row_action['Series_Title'] . '</a></td></tr>';
        }
        echo '</table>';
        $result_action->free();
    } else {
        echo "<p>No movies found in the Action genre.</p>";
    }
    ?>
        </table>

        <!-- Best Movies in Genre Animation -->
        <table class="movie-table">
            <tr>
                <th colspan="2">Best Movies in Genre Animation</th>
            </tr>
            <?php
    // Prepare the SQL query to get the best 5 films in Genre Animation
    $query_animation = "SELECT Series_Title FROM tabelle1 WHERE Genre LIKE '%Animation%' ORDER BY IMDB_Rating DESC LIMIT 5";

    // Execute the query
    $result_animation = $mysqli->query($query_animation);

    // Handle the query result for best movies in Animation genre
    if ($result_animation && $result_animation->num_rows > 0) {
        echo '<table class="movie-table">';
        echo '<colgroup>';
        echo '<col style="width: 100%">';
        echo '</colgroup>';
        echo '<tr><th>Movie</th></tr>';
        while ($row_animation = $result_animation->fetch_assoc()) {
            // Add hyperlink to the movie name
            echo '<tr><td><a href="movie_details.php?movie=' . urlencode($row_animation['Series_Title']) . '">' . $row_animation['Series_Title'] . '</a></td></tr>';
        }
        echo '</table>';
        $result_animation->free();
    } else {
        echo "<p>No movies found in the Animation genre.</p>";
    }
    ?>
        </table>
    </div>

    <div class="container-table">
        <!-- Best Movies in Genre Horror -->
        <table class="movie-table">
            <tr>
                <th colspan="2">Best Movies in Genre Horror</th>
            </tr>
            <?php
    // Prepare the SQL query to get the best 5 films in Genre Horror
    $query_horror = "SELECT Series_Title FROM tabelle1 WHERE Genre LIKE '%Horror%' ORDER BY IMDB_Rating DESC LIMIT 5";

    // Execute the query
    $result_horror = $mysqli->query($query_horror);

    // Handle the query result for best movies in Horror genre
    if ($result_horror && $result_horror->num_rows > 0) {
        echo '<table class="movie-table">';
        echo '<colgroup>';
        echo '<col style="width: 100%">';
        echo '</colgroup>';
        echo '<tr><th>Movie</th></tr>';
        while ($row_horror = $result_horror->fetch_assoc()) {
            // Add hyperlink to the movie name
            echo '<tr><td><a href="movie_details.php?movie=' . urlencode($row_horror['Series_Title']) . '">' . $row_horror['Series_Title'] . '</a></td></tr>';
        }
        echo '</table>';
        $result_horror->free();
    } else {
        echo "<p>No movies found in the Horror genre.</p>";
    }
    ?>
        </table>

        <!-- Best Movies in Genre Biography -->
        <table class="movie-table">
            <tr>
                <th colspan="2">Best Movies in Genre Biography</th>
            </tr>
             <?php
    // Prepare the SQL query to get the best 5 films in Genre Biography
    $query_biography = "SELECT Series_Title FROM tabelle1 WHERE Genre LIKE '%Biography%' ORDER BY IMDB_Rating DESC LIMIT 5";

    // Execute the query
    $result_biography = $mysqli->query($query_biography);

    // Handle the query result for best movies in Biography genre
    if ($result_biography && $result_biography->num_rows > 0) {
        echo '<table class="movie-table">';
        echo '<colgroup>';
        echo '<col style="width: 100%">';
        echo '</colgroup>';
        echo '<tr><th>Movie</th></tr>';
        while ($row_biography = $result_biography->fetch_assoc()) {
            // Add hyperlink to the movie name
            echo '<tr><td><a href="movie_details.php?movie=' . urlencode($row_biography['Series_Title']) . '">' . $row_biography['Series_Title'] . '</a></td></tr>';
        }
        echo '</table>';
        $result_biography->free();
    } else {
        echo "<p>No movies found in the Biography genre.</p>";
    }

    // Close the database connection
    $mysqli->close();
    ?>
        </table>
    </div>
</body>
</html>