<?php
include('../config/db.php');

// Get the search query from the POST request
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
}

// Start the SQL query to fetch sliders
$sql = "SELECT * FROM slider";

// Add the WHERE clause if there is a search term
if ($searchTerm != '') {
    $sql .= " WHERE description LIKE '%$searchTerm%'";
}

$no = 0;
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result) {
    // Fetch and display sliders
    while ($row = mysqli_fetch_assoc($result)) {
        $no++;
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td><p class='mb-0 f-w-500'>" . $row['title'] . "</p></td>";
        echo "<td><p class='mb-0 f-w-500'>" . $row['description'] . "</p></td>";
        echo "<td><img src='" . $row['image'] . "' width='100px' height='100px'></td>";
        echo "<td class='edit'>
                <a href='editslider.php?slider_id=" . $row['id'] . "'>
                    <button class='btn edit-item-btn btn-sm btn-success'>Edit</button>
                </a>
              </td>";
        echo "<td class='remove'>
                <a href='deleteslider.php?slider_id=" . $row['id'] . "'>
                    <button class='btn remove-item-btn btn-sm btn-danger'>Remove</button>
                </a>
              </td>";
        echo "</tr>";
    }
}
?>
