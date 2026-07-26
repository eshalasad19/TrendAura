<?php
include('../config/db.php');

$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';

$sql = "SELECT * FROM register 
        INNER JOIN role ON register.role_id = role.role_id";

// agar search term diya gaya hai to filter karein
if (!empty($search)) {
    $sql .= " WHERE register.name LIKE '%$search%' 
              OR register.email LIKE '%$search%' 
              OR role.role_name LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);
$no = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $no++;
        echo "<tr>
                <td>{$no}</td>
                <td><p class='mb-0 f-w-500'>{$row['name']}</p></td>
                <td><p class='mb-0 f-w-500'>{$row['email']}</p></td>
                <td><img src='{$row['profile_pic']}' width='100px' height='100px'></td>
                <td><p class='mb-0 f-w-500'>{$row['phone']}</p></td>
                <td><p class='mb-0 f-w-500'>{$row['address']}</p></td>
                <td>{$row['role_name']}</td>
                <td class='edit'><a href='edit_register_role.php?id={$row['id']}'><button class='btn edit-item-btn btn-sm btn-success'>Edit</button></a></td>
                <td class='remove'><a href='delete_register_role.php?id={$row['id']}'><button class='btn remove-item-btn btn-sm btn-danger'>Remove</button></a></td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
}
?>
