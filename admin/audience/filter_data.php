<?php
// Ensure no output before the headers
ob_start();
require_once('C:\xampp\htdocs\event\classes\DBConnection.php'); // Make sure this file includes your database connection setup

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a new instance of the database connection
$conn = new mysqli('localhost', 'root', '', 'event_db');

// Check connection
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

$where = [];

if ($school_year) {
    $where[] = "school_year = '" . $conn->real_escape_string($school_year) . "'";
}
if ($department) {
    $where[] = "department = '" . $conn->real_escape_string($department) . "'";
}
if ($course) {
    $where[] = "course = '" . $conn->real_escape_string($course) . "'";
}
if ($year_level) {
    $where[] = "year_level = '" . $conn->real_escape_string($year_level) . "'";
}

$where_sql = '';
if (count($where) > 0) {
    $where_sql = 'WHERE ' . implode(' AND ', $where);
}

// $sql = "SELECT * FROM event_audience $where_sql ORDER BY title ASC";
$sql = "SELECT a.*,e.title FROM event_audience a inner join event_list e on e.id = a.event_id $where_sql order by a.name ASC";

$result = $conn->query($sql);

if ($result === false) {
    // Log the error
    error_log("SQL Error: " . $conn->error);
    // Return an error response
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    ob_end_flush();
    exit();
}

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Clear the output buffer before sending the JSON response
ob_clean();
header('Content-Type: application/json');
echo json_encode($data);
ob_end_flush();
