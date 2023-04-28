<?php
//  Riku Ketomäki
require_once './functions.php';
require_once './headers.php';

try {

    $playlist_id = 1;

    $database = openDatabase();
    $sql = "select tracks.Name, Composer from tracks inner join playlist_track on tracks.TrackId=playlist_track.TrackId inner join playlists on playlist_track.PlaylistId=playlists.PlaylistId where playlists.PlaylistId = :playlistId";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(":playlistId", $playlist_id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($rows as $row) {
        echo "<h3>".$row["Name"]."</h3>"."<p>".$row["Composer"]."</p>";
    }

    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}
