<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";
?>

<h2>Audit Logs</h2>

<form id="audit-filter-form" class="filter-form">
    <label>Search:</label>
    <input type="text" name="q" id="search" placeholder="Search by user, action, table, description">

    <a href="#" id="audit-export-csv" class="button-link">Export CSV</a>
</form>

<div id="audit-table">
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Action</th>
                <th>Table</th>
                <th>Row ID</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <!-- AJAX -->
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>