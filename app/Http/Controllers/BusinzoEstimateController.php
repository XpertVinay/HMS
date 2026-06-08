<?php

namespace App\Http\Controllers;

use App\Services\BusinzoEstimateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusinzoEstimateController extends Controller
{
    public function __construct(
        private readonly BusinzoEstimateService $estimateService
    ) {}

    public function index(): View
    {
        return view('businzo.pages.estimate', [
            'estimateConfig' => $this->estimateService->getUiConfig(),
        ]);
    }

    public function calculate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'project_type' => 'required|string|in:web,mobile,ai,ecommerce,saas,custom',
            'complexity' => 'required|string|in:basic,medium,complex',
            'features' => 'nullable|array',
            'features.*' => 'string|in:auth,payment,chat,cms,multi_language,admin,multi_tenant,theme',
        ]);

        $result = $this->estimateService->calculate(
            $validated['project_type'],
            $validated['complexity'],
            $validated['features'] ?? []
        );

        return response()->json($result);
    }
}
