<?php
//  Riku Ketomäki
require_once './functions.php';
require_once './headers.php';

$database = openDatabase();

try {

    $artist_name = 'testArtist';

    // $body = file_get_contents("php://input");
    // $data = json_decode($body);
    // echo $data;
    
    // adds artist
    $sql = "insert into artists (name) values (:artistName)";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(":artistName", $artist_name);
    $stmt->execute();

    $new_artist_id = $database->lastInsertId();
    
    echo $new_artist_id."<br>";
    
    $album_name = 'testAlbum';

    // adds album for artist
    $sql = "insert into albums (Title, ArtistId) values (:albumName, $new_artist_id)";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(":albumName", $album_name);
    $stmt->execute();

    $new_album_id = $database->lastInsertId();

    echo $new_album_id;

} catch (PDOException $pdoex) {
    returnErr($pdoex);
}
