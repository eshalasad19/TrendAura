<?php
include('../config/db.php');

// Get the search query from the POST request
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
}

// Start the SQL query to fetch About Us entries
$sql = "SELECT * FROM about_us";

// Add the WHERE clause if there is a search term
if ($searchTerm != '') {
    $sql .= " WHERE about_name LIKE '%$searchTerm%' OR about_desc LIKE '%$searchTerm%'";
}

$no = 0;
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch and display About Us entries
    while ($row = mysqli_fetch_assoc($result)) {
        $no++;
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td><p class='mb-0 f-w-500'>" . $row['about_name'] . "</p></td>";
        echo "<td><p class='mb-0 f-w-500'>" . substr($row['about_desc'], 0, 30) . (strlen($row['about_desc']) > 30 ? '...' : '') . "</p></td>";
        echo "<td><img src='" . $row['about_image'] . "' width='100px' height='100px'></td>";
        echo "<td class='edit'>
                <a href='edit_about.php?about_id=" . $row['about_id'] . "'>
                    <button class='btn edit-item-btn btn-sm btn-success'>Edit</button>
                </a>
              </td>";
        echo "<td class='remove'>
                <a href='delete_about.php?about_id=" . $row['about_id'] . "'>
                    <button class='btn remove-item-btn btn-sm btn-danger'>Remove</button>
                </a>
              </td>";
        echo "</tr>";
    }
}
?>
