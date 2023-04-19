<?php

try {

    $playlist_id = 12;

    $database = openDatabase();
    $sql = "select tracks.Name, Composer from tracks inner join playlist_track on tracks.TrackId=playlist_track.TrackId inner join playlists on playlist_track.PlaylistId=playlists.PlaylistId where playlists.PlaylistId = $playlist_id";
    $stmt = $database->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // header('HTTP/1.1 200 OK');
    
    foreach ($rows as $row) {
        echo "<h3>".$row["Name"]."</h3>"."<p>".$row["Composer"]."</p>"."<br>";
    }

    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}
