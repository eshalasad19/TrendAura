<?php
include('../config/db.php');

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $likeSearch = "%$search%";

    // Query to search roles based on ID or role name
    $sql = "SELECT * FROM role WHERE role_id LIKE ? OR role_name LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $likeSearch, $likeSearch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $no = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $no++;
        $roleName = htmlspecialchars($row['role_name'], ENT_QUOTES, 'UTF-8');
        $roleId = (int) $row['role_id'];
        echo "<tr>
            <td>{$no}</td>
            <td>
                <p class='mb-0 f-w-500 '>{$roleName}</p>
            </td>
            <td class='edit'><a href='editrole.php?role_id={$roleId}'><button class='btn edit-item-btn btn-sm btn-success'>Edit</button></a>
            </td>
            <td class='remove'><a href='deleterole.php?role_id={$roleId}'><button class='btn remove-item-btn btn-sm btn-danger'>Remove</button></a>
            </td>
        </tr>";
    }

    // If no results are found
    if (mysqli_num_rows($result) == 0) {
        echo "<tr><td colspan='4' class='text-center'>No roles found</td></tr>";
    }
}
?>
