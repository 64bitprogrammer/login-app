<?
// Set header to indicate JSON response
header('Content-Type: application/json');

// Get the raw POST data
$rawInput = file_get_contents("php://input");

// Decode JSON to PHP array
$data = json_decode($rawInput, true);

// Check for decoding errors or missing data
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['data'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON or missing 'data' field"]);
    exit;
}

// Access the array sent from JavaScript
$array = $data['data'];

// Example: respond with the count and original array
$response = [
    "received_count" => count($array),
    "original_data" => $array,
    "message" => "Data processed successfully"
];

// Send JSON response
echo json_encode($response);