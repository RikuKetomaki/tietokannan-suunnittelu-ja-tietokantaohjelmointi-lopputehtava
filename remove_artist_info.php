<?php
//  Riku Ketomäki
require_once './functions.php';
require_once './headers.php';

$database = openDatabase();

try {

    $database->beginTransaction();

    $artist_id = 8;

    $safe_artist_id = strip_tags($artist_id);

    $sql = "delete from playlist_track where TrackId = any (select TrackId from tracks where AlbumId = any (select AlbumId from albums where ArtistId = $safe_artist_id))";
    $stmt = $database->prepare($sql);
    $stmt->execute();

    $sql = "delete from invoice_items where TrackId = any (select TrackId from tracks where AlbumId = any (select AlbumId from albums where ArtistId = $safe_artist_id))";
    $stmt = $database->prepare($sql);
    $stmt->execute();

    $sql = "delete from tracks where AlbumId = any (select AlbumId from albums where ArtistId = $safe_artist_id)";
    $stmt = $database->prepare($sql);
    $stmt->execute();

    $sql = "delete from albums where ArtistId = $safe_artist_id";
    $stmt = $database->prepare($sql);
    $stmt->execute();

    $sql = "delete from artists where ArtistId = $safe_artist_id";
    $stmt = $database->prepare($sql);
    $stmt->execute();

    $sql = "delete from invoices where not exists (select InvoiceId from invoice_items where invoice_items.InvoiceId = invoices.InvoiceId)";
    $stmt = $database->prepare($sql);
    $stmt->execute();
    
    $database->commit();
    
} catch (Exception $e) {
    $database->rollBack();

    echo $e->getMessage();
}