<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\ResponseFormatter;
use Database;
use Rakit\Validation\Validator;

class StaffController
{
    public function getRegistry(Request $request, Response $response)
    {
        $user = $request->getAttribute('user');
        $orgId = $user->organization_id;

        $pdo = Database::getInstance()->getPDO();

        $query = "SELECT id, person_name, created_at FROM registry";
        $params = [];

        if ($orgId) {
            $query .= " WHERE organization_id = ? ORDER BY created_at DESC";
            $params[] = $orgId;
        } else {
            $query .= " ORDER BY created_at DESC";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $registry = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return ResponseFormatter::success($response, $registry, "Registry fetched successfully");
    }

    public function addRegistry(Request $request, Response $response)
    {
        $user = $request->getAttribute('user');
        $orgId = $user->organization_id;

        $parsedBody = $request->getParsedBody();
        $validator = new Validator;

        $validation = $validator->make($parsedBody ?? [], [
            'person_name' => 'required|min:3'
        ]);
        $validation->validate();

        if ($validation->fails()) {
            return ResponseFormatter::error($response, 'Validation failed', $validation->errors()->toArray(), 422);
        }

        $personName = $parsedBody['person_name'];

        $pdo = Database::getInstance()->getPDO();

        if ($orgId) {
            $stmt = $pdo->prepare("INSERT INTO registry (person_name, organization_id) VALUES (?, ?)");
            $stmt->execute([$personName, $orgId]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO registry (person_name) VALUES (?)");
            $stmt->execute([$personName]);
        }

        return ResponseFormatter::success($response, ['id' => $pdo->lastInsertId(), 'person_name' => $personName], "Visitor added successfully");
    }
}
