<?php
//  Riku Ketomäki
require_once './functions.php';
require_once './headers.php';

try {

    $invoice_id = 1;

    $safe_invoice_id = strip_tags($invoice_id);

    $database = openDatabase();
    $sql = "delete from invoice_items where InvoiceId = $safe_invoice_id";
    $database->exec($sql);
    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}