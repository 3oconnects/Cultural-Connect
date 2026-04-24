<?php
require_once 'db.php';

// Function to generate hashed password
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

echo "Starting database seeding...\n";

// Disable foreign key checks to truncate tables
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("TRUNCATE TABLE votes");
$conn->query("TRUNCATE TABLE products");
$conn->query("TRUNCATE TABLE companies");
$conn->query("TRUNCATE TABLE residents");
$conn->query("TRUNCATE TABLE users");
$conn->query("TRUNCATE TABLE areas");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "Tables truncated.\n";

// 1. Insert Areas
$areas = ['Central', 'North', 'South', 'East', 'West'];
$areaIds = [];
foreach ($areas as $area) {
    $stmt = $conn->prepare("INSERT INTO areas (area_name) VALUES (?)");
    $stmt->bind_param("s", $area);
    $stmt->execute();
    $areaIds[] = $stmt->insert_id;
}
echo "Areas inserted.\n";

// 2. Insert Admin
$adminEmail = 'Admin@gmail.com';
$adminPass = hashPassword('Admin123');
$stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'admin')");
$adminName = 'System Admin';
$stmt->bind_param("sss", $adminName, $adminEmail, $adminPass);
$stmt->execute();
echo "Admin user created.\n";

// 3. Insert Residents
$residentsCount = 5;
$residentPass = hashPassword('resident123');
$residentIds = [];
for ($i = 1; $i <= $residentsCount; $i++) {
    $name = "Resident $i";
    $email = "resident$i@example.com";
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'resident')");
    $stmt->bind_param("sss", $name, $email, $residentPass);
    $stmt->execute();
    $userId = $stmt->insert_id;

    $areaId = $areaIds[array_rand($areaIds)];
    $phone = "077" . rand(1000000, 9999999);
    $stmtRes = $conn->prepare("INSERT INTO residents (user_id, area_id, phone) VALUES (?, ?, ?)");
    $stmtRes->bind_param("iis", $userId, $areaId, $phone);
    $stmtRes->execute();
    $residentIds[] = $stmtRes->insert_id;
}
echo "Residents created.\n";

// 4. Insert Companies
$companies = [
    ['ArtSpace Studio', 'Creative hub for local artists.', $areaIds[0]],
    ['Music Academy', 'Professional music training and practice.', $areaIds[1]],
    ['Theatre Group', 'Community performing arts collective.', $areaIds[2]],
    ['Design Hub', 'Modern design and photography studio.', $areaIds[3]]
];
$companyIds = [];
foreach ($companies as $comp) {
    $stmt = $conn->prepare("INSERT INTO companies (company_name, description, area_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $comp[0], $comp[1], $comp[2]);
    $stmt->execute();
    $companyIds[] = $stmt->insert_id;
}
echo "Companies created.\n";

// 5. Insert Products
$products = [
    ['Painting Workshop', 'Arts', 'Service', $companyIds[0], 'Learn oil painting techniques.'],
    ['Guitar Lesson', 'Music', 'Service', $companyIds[1], 'Beginner to advanced guitar classes.'],
    ['Theatre Play', 'Entertainment', 'Service', $companyIds[2], 'A local community theatre production.'],
    ['Photography Service', 'Design', 'Service', $companyIds[3], 'Professional portrait and event photography.'],
    ['Sculpting Kit', 'Arts', 'Product', $companyIds[0], 'DIY sculpting materials for home use.'],
    ['Music Sheets', 'Music', 'Product', $companyIds[1], 'Collection of classical and modern music sheets.']
];
$productIds = [];
foreach ($products as $prod) {
    $stmt = $conn->prepare("INSERT INTO products (product_name, category, type, company_id, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $prod[0], $prod[1], $prod[2], $prod[3], $prod[4]);
    $stmt->execute();
    $productIds[] = $stmt->insert_id;
}
echo "Products created.\n";

// 6. Insert Votes
foreach ($residentIds as $resId) {
    $numVotes = rand(1, 3);
    $votedProds = (array) array_rand(array_flip($productIds), $numVotes);
    foreach ((array)$votedProds as $prodId) {
        $stmt = $conn->prepare("INSERT IGNORE INTO votes (resident_id, product_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $resId, $prodId);
        $stmt->execute();
    }
}
echo "Votes created.\n";

echo "Seeding completed successfully!\n";
?>
