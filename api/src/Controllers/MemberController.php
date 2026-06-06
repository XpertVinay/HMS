<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\ResponseFormatter;
use Database;

class MemberController
{
    public function getNotices(Request $request, Response $response)
    {
        $user = $request->getAttribute('user');
        $orgId = $user->organization_id;

        $pdo = Database::getInstance()->getPDO();

        $query = "SELECT id, title, content, created_at FROM announcement";
        $params = [];

        if ($orgId) {
            $query .= " WHERE organization_id = ? ORDER BY created_at DESC";
            $params[] = $orgId;
        } else {
            $query .= " ORDER BY created_at DESC";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $notices = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return ResponseFormatter::success($response, $notices, "Notices fetched successfully");
    }

    public function getBills(Request $request, Response $response)
    {
        $user = $request->getAttribute('user');
        $orgId = $user->organization_id;

        $pdo = Database::getInstance()->getPDO();

        // Join maintenance_items and maintenance categories
        $query = "SELECT b.id, b.maintenance_id, bc.category_name, bc.amount, b.status, b.due_date, b.created_at 
                  FROM maintenance_items b 
                  LEFT JOIN maintenance bc ON b.maintenance_id = bc.id 
                  WHERE b.member_id = ?";
        
        $params = [$user->user_id];

        if ($orgId) {
            $query .= " AND b.organization_id = ?";
            $params[] = $orgId;
        }

        $query .= " ORDER BY b.due_date DESC";

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $bills = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return ResponseFormatter::success($response, $bills, "Bills fetched successfully");
    }
}
