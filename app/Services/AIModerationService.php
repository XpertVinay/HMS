<?php

namespace App\Services;

class AIModerationService
{
    /**
     * Mock AI Service that checks for predefined bad words.
     * Returns an array with 'score' (0-100) and 'feedback'.
     *
     * @param string $content
     * @return array
     */
    public function analyzeContent(string $content): array
    {
        // Simple mock rule: Check for "bad" words
        $badWords = ['spam', 'abuse', 'hate', 'scam', 'fake'];
        $contentLower = strtolower($content);
        
        $flaggedWords = [];
        foreach ($badWords as $word) {
            if (str_contains($contentLower, $word)) {
                $flaggedWords[] = $word;
            }
        }
        
        if (!empty($flaggedWords)) {
            // Highly conflictual content -> low score
            return [
                'score' => 30.0,
                'feedback' => 'Flagged due to inappropriate words: ' . implode(', ', $flaggedWords) . '. Requires manual staff review.'
            ];
        }
        
        // Seems safe
        return [
            'score' => 95.0,
            'feedback' => 'Content appears safe and meets community guidelines.'
        ];
    }
}
