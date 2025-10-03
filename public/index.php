<?php
require_once "../src/GameController.php";
require_once "../src/Response.php";

// === Handle Preflight (OPTIONS) ===
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    http_response_code(204); // No Content
    exit;
}

// สร้าง controller
$controller = new GameController();

// รับ method ของ HTTP
$method = $_SERVER['REQUEST_METHOD'];

// แยก path
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
$path = trim($path, '/');
$parts = $path === '' ? [] : explode('/', $path);

// === Test endpoint (optional) ===
if (isset($parts[0]) && $parts[0] === 'test') {
    Response::json([
        "message" => "API is working!",
        "method"  => $method,
        "path"    => $_SERVER['PATH_INFO'] ?? '/',
        "parts"   => $parts
    ], 200);
}

// === Root path /public/ ===
if (empty($parts)) {
    switch ($method) {
        case 'GET':
            // รองรับ filter ผ่าน query string เช่น /public?name=Mario
            if (!empty($_GET)) {
                $controller->getAllGames($_GET);
            } else {
                $controller->getAllGames();
            }
            break;
        case 'POST':
            if (stripos($_SERVER["CONTENT_TYPE"] ?? '', "application/json") === false) {
                Response::json(["error"=>"Content-Type must be application/json"],415);
            }
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                Response::json(["error"=>"Invalid JSON"],400);
            }
            $controller->createGame($data);
            break;
        default:
            header("Allow: GET, POST");
            Response::json(["error"=>"Method not allowed"],405);
    }
}

// === ตรวจสอบ valid fields ===
$validFields = ['id','name','publisher','category','price','rating'];
$field = $parts[0];

if (!in_array($field, $validFields)) {
    Response::json(["error"=>"Invalid endpoint"],404);
}

// === Routing สำหรับ GET / PUT / PATCH / DELETE ===
switch ($method) {
   case 'GET':
    if (count($parts) == 2) {
        $value = str_replace('_',' ',$parts[1]);

        if ($field === 'id') {
            $controller->getGame($value);

        } elseif ($field === 'name') {
            $results = $controller->getAllGames(['name'=>$value], true);
            if (empty($results)) {
                Response::json(["error"=>"Game name not found"],404);
            }
            Response::json($results,200);

        } elseif ($field === 'category') {
            $results = $controller->getAllGames(['category'=>$value], true);
            if (empty($results)) {
                Response::json(["error"=>"Game category not found"],404);
            }
            Response::json($results,200);

        } elseif ($field === 'publisher') {
            $results = $controller->getAllGames(['publisher'=>$value], true);
            if (empty($results)) {
                Response::json(["error"=>"Game publisher not found"],404);
            }
            Response::json($results,200);

        } else {
            Response::json(["error"=>"Invalid field"],400);
        }

    } else {
        Response::json(["error"=>"Invalid URL format"],400);
    }
    break;




    case 'PUT':
        if ($field === 'id' && count($parts) == 2) {
            $id = $parts[1];
            if (stripos($_SERVER["CONTENT_TYPE"] ?? '', "application/json") === false) {
                Response::json(["error"=>"Content-Type must be application/json"],415);
            }
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) Response::json(["error"=>"Invalid JSON"],400);
            $controller->updateGame($id,$data);
        } else {
            Response::json(["error"=>"Invalid URL for PUT"],400);
        }
        break;

    case 'PATCH':
        if ($field === 'id' && count($parts) == 2) {
            $id = $parts[1];
            if (stripos($_SERVER["CONTENT_TYPE"] ?? '', "application/json") === false) {
                Response::json(["error"=>"Content-Type must be application/json"],415);
            }
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) Response::json(["error"=>"Invalid JSON"],400);
            $controller->patchGame($id,$data);
        } else {
            Response::json(["error"=>"Invalid URL for PATCH"],400);
        }
        break;

    case 'DELETE':
        if ($field === 'id' && count($parts) == 2) {
            $id = $parts[1];
            $controller->deleteGame($id);
        } else {
            Response::json(["error"=>"Invalid URL for DELETE"],400);
        }
        break;

    default:
        header("Allow: GET, POST, PUT, PATCH, DELETE");
        Response::json(["error"=>"Method not allowed"],405);
        break;
}
