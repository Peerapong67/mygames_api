<?php
require_once "../src/GameController.php";
require_once "../src/Response.php";

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
    exit;
}

// === Root path /public/ ===
if (empty($parts)) {
    switch ($method) {
        case 'GET':
            $controller->getAllGames();
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                Response::json(["error"=>"Invalid JSON"],400);
            }
            $controller->createGame($data);
            break;
        default:
            Response::json(["error"=>"Method not allowed"],405);
    }
    exit;
}

// === ตรวจสอบ valid fields ===
$validFields = ['id','name','publisher','category'];
$field = $parts[0];

if (!in_array($field, $validFields)) {
    Response::json(["error"=>"Invalid endpoint"],404);
}

// === Routing สำหรับ GET / POST / PUT / PATCH / DELETE ===
switch ($method) {
    case 'GET':
        if (count($parts) == 2) {
            $value = str_replace('_',' ',$parts[1]);
            if ($field === 'id') {
                $controller->getGame($value);
            } else {
                $controller->getAllGames([$field=>$value]);
            }
        } else {
            Response::json(["error"=>"Invalid URL format"],400);
        }
        break;

    case 'POST':
        // POST for root path already handled above
        Response::json(["error"=>"Method not allowed for this endpoint"],405);
        break;

    case 'PUT':
        if ($field === 'id' && count($parts) == 2) {
            $id = $parts[1];
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
        Response::json(["error"=>"Method not allowed"],405);
        break;
}
