<?php
require_once './functions.php';
require_once './headers.php';

$database = openDatabase();

try {

    $artist_id = 11;

    $safe_artist_id = strip_tags($artist_id);

    $sql = "select Name as artist from artists where ArtistId = $safe_artist_id";
    $stmt = $database->prepare($sql);
    $stmt->execute();
    $name = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "select albums.Title as title, tracks.Name as track from artists inner join albums on artists.ArtistId=albums.ArtistId inner join tracks on albums.AlbumId=tracks.AlbumId where tracks.AlbumId = any (select albums.AlbumId from albums where albums.ArtistId = any (select artists.ArtistId from artists where ArtistId = $safe_artist_id))";
    $stmt = $database->prepare($sql);
    $stmt->execute();
    $albumsAndTitles = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $artist_name = implode(',', array_column($name, 'artist'));

    $albums = array();
    
    foreach ($albumsAndTitles as $row) {
        $album_title = $row['title'];
        $track_title = $row['track'];
    
        $album_index = null;
        foreach ($albums as $index => $album) {
            if ($album['Title'] === $album_title) {
                $album_index = $index;
                break;
            }
        }
    
        if ($album_index === null) {
            $album_index = count($albums);
            $albums[$album_index] = [
                'Title' => $album_title,
                'Tracks' => []
            ];
        }
    
        $albums[$album_index]['Tracks'][] = $track_title;
    }

    $data['Artist'] = $artist_name;
    $data['Albums'] = $albums;

    $json = json_encode($data);

    header('Content-Type: application/json');
    echo $json;

    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}