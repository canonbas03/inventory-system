<?php
//         include "../includes/db.php";

//         $search = $_GET['q'] ?? '';

//         $sql = "
// SELECT products.*, categories.name AS category, suppliers.name AS supplier
// FROM products
// LEFT JOIN categories ON products.category_id = categories.id
// LEFT JOIN suppliers ON products.supplier_id = suppliers.id
// WHERE products.name LIKE ? 
//    OR products.sku LIKE ? 
//    OR categories.name LIKE ? 
//    OR suppliers.name LIKE ?
// ";

//         $param = "%$search%";

//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("ssss", $param, $param, $param, $param);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         while ($row = $result->fetch_assoc()) {
//             echo "<tr>
//         <td>{$row['id']}</td>
//         <td>" . htmlspecialchars($row['name']) . "</td>
//         <td>" . htmlspecialchars($row['sku']) . "</td>
//         <td>{$row['quantity']}</td>
//         <td>{$row['category']}</td>
//         <td>{$row['supplier']}</td>
//         <td>{$row['price']}</td>
//         <td>
//             <a class='button-link' href='edit.php?id={$row['id']}'>Edit</a> |
//             <a class='button-link' href='delete.php?id={$row['id']}' onclick='return confirm(\"Delete this product?\")'>Delete</a>
//         </td>
//     </tr>";
//       }

// TODO