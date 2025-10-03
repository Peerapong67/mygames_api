<?php
class Response {
    public static function json($data, $status = 200) {
        http_response_code($status);
        header("Content-Type: application/json; charset=utf-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            echo json_encode(["error" => "Failed to encode JSON"]);
            exit;
        }
        echo $json;
        exit;
    }
}
