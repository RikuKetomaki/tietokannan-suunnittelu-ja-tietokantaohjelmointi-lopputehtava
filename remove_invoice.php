<?php

try {

    $invoice_id = 1;

    $database = openDatabase();
    $sql = "delete from invoice_items where InvoiceId = $invoice_id";
    $database->query($sql);
    
} catch (PDOException $pdoex) {
    returnErr($pdoex);
}