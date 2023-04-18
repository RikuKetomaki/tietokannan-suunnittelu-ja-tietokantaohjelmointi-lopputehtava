<?php

try {

    $invoice_id = 1;

    $database = openDatabase();
    $sql = "delete from invoice_items where InvoiceId = $invoice_id";
    $database->exec($sql);
    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}