<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('X-Content-Type-Options: nosniff');

const PREVIEW_LIMIT = 10;
const PREVIEW_WINDOW_SECONDS = 600;
const EXCERPT_MIN_LENGTH = 18;
const EXCERPT_MAX_LENGTH = 1200;
const CONTEXT_MAX_LENGTH = 240;
const DEFAULT_MODEL = 'gemini-2.5-flash-preview-09-2025';
const CTA_COPY = 'This is a lightweight preview. Join the beta for the fuller Linguistic Decoder experience on iPhone or Android.';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    jsonResponse(405, [
        'error' => 'Use POST to request a decoder preview.',
        'cta' => CTA_COPY,
    ]);
}

$ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if (!allowPreviewRequest($ipAddress, PREVIEW_LIMIT, PREVIEW_WINDOW_SECONDS)) {
    jsonResponse(429, [
        'error' => 'The preview is temporarily rate-limited. Please wait a few minutes or join the beta now instead.',
        'cta' => CTA_COPY,
    ]);
}

$rawBody = file_get_contents('php://input');
$request = json_decode($rawBody ?: '', true);

if (!is_array($request)) {
    jsonResponse(400, [
        'error' => 'The preview request was not valid JSON.',
        'cta' => CTA_COPY,
    ]);
}

$excerpt = sanitizeInput((string) ($request['excerpt'] ?? ''));
$context = sanitizeInput((string) ($request['context'] ?? ''));

if ($excerpt === '') {
    jsonResponse(400, [
        'error' => 'Paste a short conversation excerpt first.',
        'cta' => CTA_COPY,
    ]);
}

if (textLength($excerpt) < EXCERPT_MIN_LENGTH) {
    jsonResponse(400, [
        'error' => 'The excerpt is too short for a useful preview. Add a little more of the exchange.',
        'cta' => CTA_COPY,
    ]);
}

if (textLength($excerpt) > EXCERPT_MAX_LENGTH) {
    jsonResponse(400, [
        'error' => 'The preview only accepts short excerpts. Trim the conversation and try again.',
        'cta' => CTA_COPY,
    ]);
}

if (textLength($context) > CONTEXT_MAX_LENGTH) {
    jsonResponse(400, [
        'error' => 'Keep the optional context shorter for the web preview.',
        'cta' => CTA_COPY,
    ]);
}

$apiKey = firstEnvValue([
    'DECODER_GEMINI_API_KEY',
    'GEMINI_API_KEY',
    'GOOGLE_GEMINI_API_KEY',
]);

if ($apiKey === null) {
    jsonResponse(503, [
        'error' => 'The preview is not configured right now. You can still join the beta below.',
        'cta' => CTA_COPY,
    ]);
}

$model = trim((string) (getenv('GEMINI_MODEL') ?: DEFAULT_MODEL));

$systemPrompt = <<<PROMPT
You are the Linguistic Decoder web preview.

Your job is to analyse a short written conversation excerpt and produce a lightweight, grounded preview.

Rules:
- Do not go looking for conflict to make the app interesting.
- If conflict is not clearly present, do not imply it.
- Use cautious language such as "may", "could", "suggests", and "seems".
- Focus on observable communication features such as tone, pacing, directness, reassurance, reciprocity, ambiguity, or follow-through.
- Find value in ordinary communication, not only tense exchanges.
- Do not diagnose, moralise, or give legal, medical, crisis, or safety advice.
- Do not claim certainty about motives, hidden meanings, or relationship dynamics.
- If the excerpt does not contain enough signal, say so plainly and still offer one practical reflection prompt.
- Keep each field concise: one or two short sentences.

Return JSON with exactly these string fields:
- toneSnapshot
- possiblePattern
- easyToMiss
- reflectionPrompt
PROMPT;

$userPrompt = "Conversation excerpt:\n{$excerpt}\n\nContext:\n" . ($context !== '' ? $context : 'No extra context provided.');

$payload = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                ['text' => $userPrompt],
            ],
        ],
    ],
    'systemInstruction' => [
        'parts' => [
            ['text' => $systemPrompt],
        ],
    ],
    'generationConfig' => [
        'responseMimeType' => 'application/json',
        'responseSchema' => [
            'type' => 'OBJECT',
            'properties' => [
                'toneSnapshot' => ['type' => 'STRING'],
                'possiblePattern' => ['type' => 'STRING'],
                'easyToMiss' => ['type' => 'STRING'],
                'reflectionPrompt' => ['type' => 'STRING'],
            ],
            'required' => [
                'toneSnapshot',
                'possiblePattern',
                'easyToMiss',
                'reflectionPrompt',
            ],
        ],
    ],
];

try {
    $analysis = requestGeminiPreview($model, $apiKey, $payload);
} catch (RuntimeException $exception) {
    jsonResponse(503, [
        'error' => $exception->getMessage(),
        'cta' => CTA_COPY,
    ]);
}

jsonResponse(200, [
    'toneSnapshot' => cleanOutputField($analysis['toneSnapshot'] ?? ''),
    'possiblePattern' => cleanOutputField($analysis['possiblePattern'] ?? ''),
    'easyToMiss' => cleanOutputField($analysis['easyToMiss'] ?? ''),
    'reflectionPrompt' => cleanOutputField($analysis['reflectionPrompt'] ?? ''),
    'cta' => CTA_COPY,
]);

function allowPreviewRequest(string $ipAddress, int $limit, int $windowSeconds): bool
{
    $bucketPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'digitalabcs_decoder_preview_' . sha1($ipAddress) . '.json';
    $handle = @fopen($bucketPath, 'c+');

    if ($handle === false) {
        return true;
    }

    $now = time();
    $allowed = true;

    try {
        if (!flock($handle, LOCK_EX)) {
            return true;
        }

        $raw = stream_get_contents($handle);
        $bucket = [
            'count' => 0,
            'reset' => $now + $windowSeconds,
        ];

        if (is_string($raw) && trim($raw) !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $bucket['count'] = (int) ($decoded['count'] ?? 0);
                $bucket['reset'] = (int) ($decoded['reset'] ?? ($now + $windowSeconds));
            }
        }

        if ($bucket['reset'] <= $now) {
            $bucket['count'] = 0;
            $bucket['reset'] = $now + $windowSeconds;
        }

        if ($bucket['count'] >= $limit) {
            $allowed = false;
        } else {
            $bucket['count']++;
            rewind($handle);
            ftruncate($handle, 0);
            fwrite($handle, json_encode($bucket));
        }

        flock($handle, LOCK_UN);
    } finally {
        fclose($handle);
    }

    return $allowed;
}

function sanitizeInput(string $value): string
{
    $normalized = str_replace(["\r\n", "\r"], "\n", $value);
    $normalized = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $normalized) ?? $normalized;
    return trim($normalized);
}

function cleanOutputField(string $value): string
{
    $clean = trim(preg_replace('/\s+/u', ' ', $value) ?? $value);

    if ($clean === '') {
        return 'Not enough signal was present to return a grounded preview.';
    }

    return $clean;
}

function textLength(string $value): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($value);
    }

    return strlen($value);
}

function firstEnvValue(array $keys): ?string
{
    foreach ($keys as $key) {
        $value = getenv($key);
        if (is_string($value) && trim($value) !== '') {
            return trim($value);
        }
    }

    return null;
}

function requestGeminiPreview(string $model, string $apiKey, array $payload): array
{
    if (!function_exists('curl_init')) {
        throw new RuntimeException('The preview is unavailable right now. You can still join the beta below.');
    }

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($model) . ':generateContent?key=' . urlencode($apiKey);
    $body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    if ($body === false) {
        throw new RuntimeException('The preview request could not be prepared right now.');
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 15,
    ]);

    $rawResponse = curl_exec($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($rawResponse === false || $curlError !== '') {
        throw new RuntimeException('The preview timed out. You can still join the beta below.');
    }

    $decoded = json_decode($rawResponse, true);
    if (!is_array($decoded)) {
        throw new RuntimeException('The preview returned an unreadable response. You can still join the beta below.');
    }

    if ($httpCode < 200 || $httpCode >= 300) {
        if ($httpCode === 429) {
            throw new RuntimeException('The preview is busy right now. Please try again shortly or join the beta below.');
        }

        throw new RuntimeException('The preview is unavailable right now. You can still join the beta below.');
    }

    $text = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? null;
    if (!is_string($text) || trim($text) === '') {
        throw new RuntimeException('The preview did not return a usable result. You can still join the beta below.');
    }

    $analysis = json_decode($text, true);
    if (!is_array($analysis)) {
        throw new RuntimeException('The preview returned an unreadable analysis. You can still join the beta below.');
    }

    return $analysis;
}

function jsonResponse(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
