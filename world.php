<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Establish database connection
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if a 'country' parameter is provided in the URL
if (isset($_GET['country'])) {
    $country = $_GET['country'];
    // Prepare a query to filter by country name using a LIKE operator
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);
} else {
    // If no 'country' parameter, retrieve all countries
    $stmt = $conn->query("SELECT * FROM countries");
}

// Fetch the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the results
?>
<ul>
<?php if (!empty($results)): ?>
    <?php foreach ($results as $row): ?>
        <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
    <?php endforeach; ?>
<?php else: ?>
    <li>No results found.</li>
<?php endif; ?>
</ul>
