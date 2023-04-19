<?php
require_once './functions.php';
require_once './headers.php';

$database = openDatabase();

try {

    $artist_id = 11;

    // $database = openDatabase();
    // $sql = "select artists.Name, albums.Title, tracks.Name from artists inner join albums on artists.ArtistId=albums.ArtistId inner join tracks on albums.AlbumId=tracks.AlbumId where tracks.AlbumId = any (select albums.AlbumId from albums where albums.ArtistId = any (select artists.ArtistId from artists where ArtistId = $artist_id))";
    // $stmt = $database->prepare($sql);
    // $stmt->execute();
    // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $artist_info = array();
    $albums = array();

    $artist = new stdClass();

    $sql = "select Name from artists where ArtistId = $artist_id";
    $stmt = $database->prepare($sql);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "select Title from albums where ArtistId = $artist_id";
    $stmt = $database->prepare($sql);
    $stmt->execute();
    $title = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "select Name, Title from tracks inner join albums on tracks.AlbumId=albums.AlbumId where tracks.AlbumId = any (select albums.AlbumId from albums where ArtistId = 11) ";
    $stmt = $database->prepare($sql);
    $stmt->execute();
    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);



    $artist->Artist = $name;
    $artist->Albums = $albums;



    $artist_info[] = $artist;

    $json = json_encode($artist_info);

    header('Content-Type: application/json');
    echo $json;

    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}