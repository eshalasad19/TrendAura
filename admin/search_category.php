<?php
include('../config/db.php');

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $likeSearch = "%$search%";

    // SQL query to search categories
    $sql = "SELECT * FROM category WHERE category_name LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $likeSearch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $no = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $no++;
            $catName = htmlspecialchars($row['category_name'], ENT_QUOTES, 'UTF-8');
            $catImage = htmlspecialchars($row['category_image'], ENT_QUOTES, 'UTF-8');
            $catId = (int) $row['category_id'];
            echo "<tr>
                    <td>{$no}</td>
                    <td>
                        <p class='mb-0 f-w-500'>{$catName}</p>
                    </td>
                    <td><img src='{$catImage}' width='100px' height='100px'></td>
                    <td class='edit'>
                        <a href='editcategory.php?category_id={$catId}'>
                            <button class='btn edit-item-btn btn-sm btn-success'>Edit</button>
                        </a>
                    </td>
                    <td class='remove'>
                        <a href='deletecategory.php?category_id={$catId}'>
                            <button class='btn remove-item-btn btn-sm btn-danger'>Remove</button>
                        </a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>No categories found</td></tr>";
    }
}
?>
