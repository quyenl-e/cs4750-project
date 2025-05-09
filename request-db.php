<?php

function getMovieInfo()
{
    global $db;
    $query = "SELECT title, releaseYear, runtime, avgRating FROM movie NATURAL JOIN imdb_info";
    
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getMoviebyTitle()
{
    global $db;
    $query = "SELECT title, releaseYear, runtime, avgRating FROM movie NATURAL JOIN imdb_info WHERE title like :searchTerm";
    $searchTerm = '%' . $searchTerm . '%';
    
    $statement = $db->prepare($query);

    $statement->bindValue(':searchTerm', $searchTerm);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getCrewbyMovieID($movieID) {
    global $db;
    $query = "SELECT crewID, cname FROM crew NATURAL JOIN works_for WHERE movieID=:movieID";

    $statement = $db->prepare($query);

    $statement->bindValue('movieID', $movieID);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getJobsbyCrewID($crewID, $movieID) {
    global $db;
    $query = "SELECT jobTitle FROM crew_job NATURAL JOIN works_for WHERE crewID=:crewID AND movieID=:movieID";

    $statement = $db->prepare($query);

    $statement->bindValue('crewID', $crewID);
    $statement->bindValue('movieID', $movieID);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getReviewbyUserID($userID)
{
    global $db;
    $query = "SELECT title, rating, content FROM review NATURAL JOIN movie WHERE userID=:userID";

    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getReviewbyMovieID($movieID)
{
    global $db;
    $query = "SELECT title, rating, content FROM review NATURAL JOIN movie WHERE movieID=:movieID";

    $statement = $db->prepare($query);

    $statement->bindValue(':movieID', $movieID);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getWatchlistbyUserID($userID)
{
    global $db;
    $query = "SELECT ltitle, list_desc FROM watchlist WHERE userID=:userID";

    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getMoviesbyListID($listID)
{
    global $db;
    $query = 'SELECT title, releaseYear, avgRating FROM is_added NATURAL JOIN movie NATURAL JOIN imdb_info WHERE listID=:listID';

    $statement = $db->prepare($query);

    $statement->bindValue(':listID', $listID);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function addReview($userID, $movieID, $rating, $content)
{
    global db;
    $query = "INSERT INTO review (userID, movieID, rating, content) VALUES (:userID, :movieID, :rating, :content)";

    try {
        $statement = $db->prepare($query)
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':movieID', $movieID);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':content', $content);

        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e)
    {
        $e->getMessage();
    }
}

function addWatchlist($ltitle, $userID)
{
    global $db;
    $query = "INSERT INTO watchlist (ltitle, list_desc, userID) VALUES (:ltitle, :list_desc, :userID)";

    try {
        $statement = $db->prepare($query)
        $statement->bindValue(':ltitle', $ltitle);
        $statement->bindValue(':list_desc', $list_desc);
        $statement->bindValue(':userID', $userID);

        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e)
    {
        $e->getMessage();
    }
}

function addMovie($movieID, $listID, $has_watched)
{
    global $db;
    $query = "INSERT INTO is_added (movieID, listID, has_watched) VALUES (:movieID, :listID, :has_watched)";

    try {
        $statement = $db->prepare($query)
        $statement->bindValue(':movieID', $movieID);
        $statement->bindValue(':listID', $movieID);
        $statement->bindValue(':has_watched', $has_watched);

        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e)
    {
        $e->getMessage();
    }
}

function updateReview($userID, $movieID, $rating, $content)
{
    global $db;
    $query = "UPDATE review SET rating=:rating, content=:content WHERE userID=:userID AND movieID=:movieID";

    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':movieID', $movieID);
    $statement->bindValue(':rating', $rating);
    $statement->bindValue(':content', $content);

    $statement->execute();
    $statement->closeCursor();
}

function updateStatus($movieID, $listID, $has_watched)
{
    global $db;
    $query = "UPDATE is_added SET has_watched=:has_watched WHERE movieID=:movieID AND listID=:listID";

    $statement = $db->prepare($query);

    $statement->bindValue(':movieID', $movieID);
    $statement->bindValue(':listID', $movieID);
    $statement->bindValue(':has_watched', $has_watched);

    $statement->execute();
    $statement->closeCursor();
}

function deleteWatchlist($listID)
{
    global $db;
    $query = "DELETE FROM watchlist WHERE listID=:listID";

    $statement = $db->prepare($query);    
    $statement->bindValue(':listID', $listID);
    $statement->execute();
    $statement->closeCursor();
}

function deleteReview($userID, $movieID)
{
    global $db;
    $query = "DELETE FROM review WHERE userID=:userID AND movieID=:movieID";

    $statement = $db->prepare($query);    
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':movieID', $movieID);
    $statement->execute();
    $statement->closeCursor();
}

function deleteMovie($movieID, $listID)
{
    global $db;
    $query = "DELETE FROM is_added WHERE movieID=:movieID AND listID=:listID";

    $statement = $db->prepare($query);    
    $statement->bindValue(':movieID', $movieID);
    $statement->bindValue(':listID', $movieID);
    $statement->execute();
    $statement->closeCursor();
}

function filterMovieByGenre($gname)
{
    global db;
    $query = "SELECT title, releaseYear FROM movie NATURAL JOIN movie_genre WHERE gname=:gname";
    
    $statement = $db->prepare($query)
    $statement->bindValue(':gname', $gname);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    return $result;
}

function filterMovieByRating($avgRating) 
{
    global db;
    $query = "SELECT title, releaseYear, runtime, avgRating FROM movie NATURAL JOIN imdb_info WHERE avgRating > :avgRating";
    
    $statement = $db->prepare($query)
    $statement->bindValue(':avgRating', $avgRating);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    return $result;
}

?>