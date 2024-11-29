<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Retrieve the country query parameter
$country = $_GET['country'] ?? '';
$query = "SELECT name, continent, independence_year, head_of_state FROM countries";

if ($country) {
    // Use a LIKE query for partial search
    $query .= " WHERE name LIKE :country";
}

$stmt = $conn->prepare($query);

// Bind the country parameter if provided
if ($country) {
    $stmt->bindValue(':country', "%$country%");
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Start building the HTML table
echo "<table border='1' style='width:100%; border-collapse: collapse;'>";
echo "<thead>";
echo "<tr>
        <th>Name</th>
        <th>Continent</th>
        <th>Independence Year</th>
        <th>Head of State</th>
      </tr>";
echo "</thead>";
echo "<tbody>";

// Populate table rows with data
foreach ($results as $row) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
    echo "<td>" . htmlspecialchars($row['independence_year'] ?? 'N/A') . "</td>";
    echo "<td>" . htmlspecialchars($row['head_of_state'] ?? 'N/A') . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
?>

