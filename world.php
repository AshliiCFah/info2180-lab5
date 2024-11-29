<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Retrieve the query parameters
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? 'country'; // Default to 'country' lookup

if ($lookup === 'cities') {
    // Query for cities in the specified country
    $query = "SELECT cities.name AS city_name, cities.district, cities.population 
              FROM cities
              JOIN countries ON cities.country_code = countries.code
              WHERE countries.name LIKE :country";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':country', "%$country%");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Build the HTML table for cities
    echo "<table border='1' style='width:100%; border-collapse: collapse;'>";
    echo "<thead>";
    echo "<tr>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
          </tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['district']) . "</td>";
        echo "<td>" . htmlspecialchars($row['population']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    // Default behavior: Query for country information
    $query = "SELECT name, continent, independence_year, head_of_state FROM countries";
    if ($country) {
        $query .= " WHERE name LIKE :country";
    }

    $stmt = $conn->prepare($query);
    if ($country) {
        $stmt->bindValue(':country', "%$country%");
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Build the HTML table for countries
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
}
?>

