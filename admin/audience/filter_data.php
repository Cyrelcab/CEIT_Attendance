<?php
ob_start();
require_once('C:\xampp\htdocs\event\classes\DBConnection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'event_db');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    ob_end_flush();
    exit();
}

$school_year = isset($_GET['school_year']) && $_GET['school_year'] != 'default' ? $_GET['school_year'] : '';
$department = isset($_GET['department']) && $_GET['department'] != 'default' ? $_GET['department'] : '';
$course = isset($_GET['course']) && $_GET['course'] != 'default' ? $_GET['course'] : '';
$year_level = isset($_GET['year_level']) && $_GET['year_level'] != 'default' ? $_GET['year_level'] : '';

$sql = "SELECT a.*, e.title FROM event_audience a INNER JOIN event_list e ON e.id = a.event_id WHERE 1=1";
$types = '';
$params = [];

if ($school_year) {
    $sql .= " AND a.school_year = ?";
    $types .= 's';
    $params[] = $school_year;
}
if ($department) {
    $sql .= " AND a.department = ?";
    $types .= 's';
    $params[] = $department;
}
if ($course) {
    $sql .= " AND a.course = ?";
    $types .= 's';
    $params[] = $course;
}
if ($year_level) {
    $sql .= " AND a.year_level = ?";
    $types .= 's';
    $params[] = $year_level;
}

$sql .= " ORDER BY a.name ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

ob_clean();
header('Content-Type: application/json');
echo json_encode($data);
ob_end_flush();
?>