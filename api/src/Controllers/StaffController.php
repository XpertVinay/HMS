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

        $query = "SELECT r.id, r.visitor_name, r.visitor_contact, r.purpose, r.status, r.created_at, r.out_time, m.username as host_name FROM registry r LEFT JOIN member m ON r.host_id = m.id";
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
            'visitor_name' => 'required|min:3',
            'host_id' => 'required|numeric',
            'visitor_contact' => 'required',
            'purpose' => 'required'
        ]);
        $validation->validate();

        if ($validation->fails()) {
            return ResponseFormatter::error($response, 'Validation failed', $validation->errors()->toArray(), 422);
        }

        $visitorName = $parsedBody['visitor_name'];
        $hostId = $parsedBody['host_id'];
        $visitorContact = $parsedBody['visitor_contact'];
        $purpose = $parsedBody['purpose'];

        $pdo = Database::getInstance()->getPDO();

        if ($orgId) {
            $stmt = $pdo->prepare("INSERT INTO registry (visitor_name, host_id, visitor_contact, purpose, organization_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$visitorName, $hostId, $visitorContact, $purpose, $orgId]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO registry (visitor_name, host_id, visitor_contact, purpose) VALUES (?, ?, ?, ?)");
            $stmt->execute([$visitorName, $hostId, $visitorContact, $purpose]);
        }

        return ResponseFormatter::success($response, ['id' => $pdo->lastInsertId(), 'visitor_name' => $visitorName], "Visitor added successfully");
    }
}
