<?php
function addRequests($reqDate, $roomNumber, $reqBy, $repairDesc, $reqPriority)
{
    global $db;

    $reqDate = date('Y-m-d');

    $query = "INSERT INTO requests (reqDate, roomNumber, reqBy, repairDesc, reqPriority) VALUES (:reqDate, :roomNumber, :reqBy, :repairDesc, :reqPriority)";

    try {
        // $statement = $db->query($query); // compile & exe

        // prepared statement
        // pre-compile
        $statement = $db->prepare($query);

        // fill in the value
        $statement->bindValue(':reqDate', $reqDate);
        $statement->bindValue(':roomNumber', $roomNumber);
        $statement->bindValue(':reqBy', $reqBy);
        $statement->bindValue(':repairDesc', $repairDesc);
        $statement->bindValue(':reqPriority', $reqPriority);

        // exe
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e)
    {
        $e->getMessage();
    }
}

function getMovieInfo()
{
    global $db;
    $query = "SELECT title, releaseYear FROM movie;";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getRequestById($id)  
{
    global $db;
    $query = "select * from requests where reqId=:reqId"; 
    $statement = $db->prepare($query);    // compile
    $statement->bindValue(':reqId', $id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
 
    return $result;
}

function updateRequest($reqId, $reqDate, $roomNumber, $reqBy, $repairDesc, $reqPriority)
{
    global $db;
    $query = "update requests set reqDate=:reqDate, roomNumber=:roomNumber, reqBy=:reqBy, repairDesc=:repairDesc, reqPriority=:reqPriority where reqId=:reqId";

    $statement = $db->prepare($query);
    
    $statement->bindValue(':reqId', $id);
    $statement->bindValue(':reqDate', $reqDate);
    $statement->bindValue(':roomNumber', $roomNumber);
    $statement->bindValue(':reqBy', $reqBy);
    $statement->bindValue(':repairDesc', $repairDesc);
    $statement->bindValue(':reqPriority', $reqPriority);

    $statement->execute();
    $statement->closeCursor();
}

function deleteRequest($reqId)
{

    
}

?>
