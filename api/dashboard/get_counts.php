<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";

// Fetch all counts
$total_products = $conn->query("SELECT COUNT(*) AS c FROM products")->fetch_assoc()['c'];
$total_categories = $conn->query("SELECT COUNT(*) AS c FROM categories")->fetch_assoc()['c'];
$total_suppliers = $conn->query("SELECT COUNT(*) AS c FROM suppliers")->fetch_assoc()['c'];

echo $total_products . "|||" . $total_categories . "|||" . $total_suppliers;
