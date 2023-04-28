<?php
//  Riku Ketomäki
require_once './functions.php';
require_once './headers.php';

try {

    $invoice_id = 15;

    $database = openDatabase();
    $sql = "delete from invoice_items where InvoiceId = :invoiceId";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(":invoiceId", $invoice_id);
    $stmt->execute();
    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}