<?php
include('../config/db.php');

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $likeSearch = "%$search%";

    // SQL query to search sub-categories
    $sql = "SELECT * FROM sub_category 
            INNER JOIN category ON sub_category.category_id = category.category_id 
            WHERE sub_category.sub_name LIKE ? OR category.category_name LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $likeSearch, $likeSearch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $no = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $no++;
            $subName = htmlspecialchars($row['sub_name'], ENT_QUOTES, 'UTF-8');
            $subImage = htmlspecialchars($row['sub_image'], ENT_QUOTES, 'UTF-8');
            $categoryName = htmlspecialchars($row['category_name'], ENT_QUOTES, 'UTF-8');
            $subId = (int) $row['sub_id'];
            echo "<tr>
                    <td>{$no}</td>
                    <td>
                        <p class='mb-0 f-w-500'>{$subName}</p>
                    </td>
                    <td><img src='{$subImage}' width='100px' height='100px'></td>
                    <td>{$categoryName}</td>
                    <td class='edit'>
                        <a href='edit_sub_category.php?sub_category_id={$subId}'>
                            <button class='btn edit-item-btn btn-sm btn-success'>Edit</button>
                        </a>
                    </td>
                    <td class='remove'>
                        <a href='delete_sub_category.php?sub_category_id={$subId}'>
                            <button class='btn remove-item-btn btn-sm btn-danger'>Remove</button>
                        </a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>No sub-categories found</td></tr>";
    }
}
?>
