<?php
require("connect-db.php");
require("request-db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7; /* Light gray background */
            color: #333; /* Dark gray text color */
        }
        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1a1037; /* Dark purple sidebar */
            padding-top: 20px;
        }
        .sidenav a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #f7f7f7; /* White text color */
            display: block;
        }
        .sidenav a:hover {
            background-color: #291d4d; /* Darker purple hover color */
            color: #f7f7f7; /* White text color */
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .search-container {
            text-align: center;
            margin-top: 100px;
        }
        .search-box {
            width: 400px;
            padding: 10px;
            font-size: 18px;
            border: 2px solid #1a1037; /* Dark purple border */
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #f7f7f7; /* Light gray background */
            color: #333; /* Dark gray text color */
            outline: none;
        }
        .search-button,
        .filter-button {
            background-color: #1a1037; /* Dark purple button */
            color: #f7f7f7; /* White text color */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
        }
        .search-button:hover,
        .filter-button:hover {
            background-color: #291d4d; /* Darker hover color */
        }
    </style>
</head>
<body>

<div class="sidenav">
    <a href="#">Watchlist</a>
    <a href="#">Search Page</a>
    <a href="#">Sign In</a>
</div>

<div class="content">
    <div class="search-container">
        <h1>Welcome to My Website</h1>
        <form action="search.php" method="GET">
            <input type="text" name="query" class="search-box" placeholder="Search...">
            <button type="submit" class="search-button">Search</button>
            <button type="button" class="filter-button">Filter</button>
        </form>
    </div>
</div>

</body>
</html>