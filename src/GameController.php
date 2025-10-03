<?php
require_once "Database.php";
require_once "Response.php";

class GameController {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // GET by ID
    public function getGame($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM games WHERE id=?");
            $stmt->execute([$id]);
            $game = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($game) {
                Response::json($game, 200);
            } else {
                Response::json(["error"=>"Game not found"],404);
            }
        } catch(PDOException $e) {
            Response::json(["error"=>"Database error: ".$e->getMessage()],500);
        }
    }

    // GET all or filter
    public function getAllGames($filters = [], $returnOnly = false) {
    try {
        $sql = "SELECT * FROM games";
        $params = [];
        if (!empty($filters)) {
            $conditions = [];
            $allowed = ['id','name','publisher','category','price','rating'];
            foreach($filters as $field => $value) {
                if (in_array($field, $allowed)) {
                    $conditions[] = "$field LIKE ?";
                    $params[] = "%$value%";
                }
            }
            if (!empty($conditions)) {
                $sql .= " WHERE ".implode(" AND ", $conditions);
            }
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($returnOnly) {
            return $games; // ส่งกลับให้ index.php handle
        }

        Response::json($games, 200);
    } catch(PDOException $e) {
        Response::json(["error"=>"Database error: ".$e->getMessage()],500);
    }
}

    // POST create
    public function createGame($data) {
        if (!isset($data["name"], $data["publisher"], $data["category"], $data["price"], $data["rating"])) {
            Response::json(["error"=>"Missing fields"],400);
        }

        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO games (name, publisher, category, price, rating) VALUES (?,?,?,?,?)"
            );
            $success = $stmt->execute([
                $data["name"], 
                $data["publisher"], 
                $data["category"], 
                number_format((float)$data["price"],2,'.',''), 
                (float)$data["rating"]
            ]);

            if ($success) {
                Response::json(["message"=>"Created successfully"],201);
            } else {
                Response::json(["error"=>"Failed to create"],500);
            }
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                Response::json(["error"=>"Game already exists"],409);
            } else {
                Response::json(["error"=>"Database error: ".$e->getMessage()],500);
            }
        }
    }

    // PUT full update
    public function updateGame($id, $data) {
        if (!isset($data["name"], $data["publisher"], $data["category"], $data["price"], $data["rating"])) {
            Response::json(["error"=>"Missing fields"],400);
        }

        try {
            $stmt = $this->conn->prepare(
                "UPDATE games SET name=?, publisher=?, category=?, price=?, rating=? WHERE id=?"
            );
            $stmt->execute([
                $data["name"], 
                $data["publisher"], 
                $data["category"], 
                number_format((float)$data["price"],2,'.',''), 
                (float)$data["rating"], 
                $id
            ]);

            if ($stmt->rowCount() > 0) {
                $this->getGame($id);
            } else {
                Response::json(["error"=>"Game not found or no changes made"],404);
            }
        } catch(PDOException $e) {
            Response::json(["error"=>"Database error: ".$e->getMessage()],500);
        }
    }

    // PATCH partial update
    public function patchGame($id, $data) {
        if (empty($data)) {
            Response::json(["error"=>"No data provided"],400);
        }

        $fields = [];
        $params = [];
        $allowed = ['name','publisher','category','price','rating'];

        foreach($allowed as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field=?";
                if ($field == 'price') {
                    $params[] = number_format((float)$data[$field],2,'.','');
                } elseif ($field == 'rating') {
                    $params[] = (float)$data[$field];
                } else {
                    $params[] = $data[$field];
                }
            }
        }

        if (empty($fields)) {
            Response::json(["error"=>"No valid fields to update"],400);
        }

        $params[] = $id;

        try {
            $sql = "UPDATE games SET ".implode(',', $fields)." WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);

            if ($stmt->rowCount() > 0) {
                $this->getGame($id);
            } else {
                Response::json(["error"=>"Game not found or no changes made"],404);
            }
        } catch(PDOException $e) {
            Response::json(["error"=>"Database error: ".$e->getMessage()],500);
        }
    }

    // DELETE
    public function deleteGame($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM games WHERE id=?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                Response::json(["message"=>"Deleted successfully"],200);
            } else {
                Response::json(["error"=>"Game not found"],404);
            }
        } catch(PDOException $e) {
            Response::json(["error"=>"Database error: ".$e->getMessage()],500);
        }
    }
}
