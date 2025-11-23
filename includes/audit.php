<?php
function log_action($conn, $user_id, $action, $target_table = null, $target_id = null, $details = null)
{
    $stmt = $conn->prepare("
        INSERT INTO audit_log (user_id, action, target_table, target_id, details)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issis", $user_id, $action, $target_table, $target_id, $details);
    $stmt->execute();
}
