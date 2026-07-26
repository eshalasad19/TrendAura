<?php
include('../config/db.php');

$search = isset($_POST['search']) ? $_POST['search'] : '';
$likeSearch = "%$search%";

// Query the database based on the search input
$sql = "SELECT * FROM product 
        INNER JOIN category ON product.cat_id = category.category_id
        INNER JOIN sub_category ON product.sub_cat_id = sub_category.sub_id
        WHERE product_name LIKE ? 
        OR category_name LIKE ? 
        OR sub_name LIKE ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sss", $likeSearch, $likeSearch, $likeSearch);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$no = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $no++;
        $productName = htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8');
        $productDesc = htmlspecialchars(substr($row['product_desc'], 0, 20), ENT_QUOTES, 'UTF-8');
        $productImage = htmlspecialchars($row['product_image'], ENT_QUOTES, 'UTF-8');
        $categoryName = htmlspecialchars($row['category_name'], ENT_QUOTES, 'UTF-8');
        $subName = htmlspecialchars($row['sub_name'], ENT_QUOTES, 'UTF-8');
        $productId = (int) $row['product_id'];
        echo '<tr>
                <td>' . $no . '</td>
                <td><p class="mb-0 f-w-500 ">' . $productName . '</p></td>
                <td><p class="mb-0 f-w-500 ">' . $productDesc . (strlen($row['product_desc']) > 100 ? '...' : '') . '</p></td>
                <td><img src="' . $productImage . '" width="100px" height="100px"></td>
                <td><p class="mb-0 f-w-500 ">' . number_format($row['product_price']) . '</p></td>
                <td><p class="mb-0 f-w-500 ">' . (int) $row['stock'] . '</p></td>
                <td>' . $categoryName . '</td>
                <td>' . $subName . '</td>
                <td class="edit"><a href="editproduct.php?product_id=' . $productId . '"><button class="btn edit-item-btn btn-sm btn-success">Edit</button></a></td>
                <td class="remove"><a href="deleteproduct.php?product_id=' . $productId . '"><button class="btn remove-item-btn btn-sm btn-danger">Remove</button></a></td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="10" class="text-center">No products found</td></tr>';
}
?>
