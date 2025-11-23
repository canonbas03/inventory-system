<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /inventory/auth/login.php");
    exit;
}

$result = $conn->query("
    SELECT a.*, u.username
    FROM audit_log a
    LEFT JOIN users u ON a.user_id = u.id
    ORDER BY a.created_at DESC
");

?>

<h2>Audit Log</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Action</th>
        <th>Table</th>
        <th>Target ID</th>
        <th>Details</th>
        <th>Time</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['action'] ?></td>
            <td><?= $row['target_table'] ?></td>
            <td><?= $row['target_id'] ?></td>
            <td><?= htmlspecialchars($row['details']) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include "../includes/footer.php"; ?>