<?php
//  Riku Ketomäki
require_once './functions.php';
require_once './headers.php';

$database = openDatabase();

/*
Json used:
[   
    {
        "artist": "testArtist",
        "album": "testAlbum",
        "tracks": [
            "testTrack1", 
            "testTrack2",
            "testTrack3",
            "testTrack4"
        ]
    }
]
*/

try {

    $body = file_get_contents("php://input");
    $data = json_decode($body);
    
    // adds artist
    $sql = "insert into artists (name) values (?)";
    $stmt = $database->prepare($sql);
    foreach ($data as $row) {
    $stmt->execute(array($row->artist));
    }

    $new_artist_id = $database->lastInsertId();


    // adds album for artist
    $sql = "insert into albums (Title, ArtistId) values (?, ?)";
    $stmt = $database->prepare($sql);
    foreach ($data as $row) {
        $stmt->execute(array($row->album, $new_artist_id));
    }

    $new_album_id = $database->lastInsertId();

    $sql = "insert into tracks (Name, AlbumId, MediaTypeId, GenreId) values (?, ?, 1, 2)";
    $stm = $database->prepare($sql);
    $trackNum = 0;
    foreach ($data as $row) {
        // for ($i=0; $i < $data->tracks.length; $i++) { 
            $stmt->execute(array($row->tracks[$i], $new_album_id,));
        //    $trackNum = $trackNum + 1;
        // }
    }

} catch (PDOException $pdoex) {
    returnErr($pdoex);
}
