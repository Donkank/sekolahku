<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends Controller
{
    public function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $payload = [
            'success' => true,
            'message' => $message,
            'result'  => $result
        ];

        return response()->json($payload, $code);
    }

    public function sendError($error, $errorMessage = [], $code = 404): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $error,
            'result'  => $errorMessage
        ];

        return response()->json($payload, $code);
    }

    public function generateTagName($tagName): string
    {
        $name = trim($tagName);

        $name = strtolower($name);

        $name = preg_replace('/[^a-zA-Z0-9]/', '-', $name);

        $name = preg_replace('/-{2,}/', '-', $name);

        $name = trim($name, '-');

        return $name;
    }

    public function generateToken(): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        $string = str_shuffle($pin);

        return $string;
    }

    public function getExcerpt($content, $length = 50, $more = '...'): string
    {
        $excerpt = strip_tags(trim($content));
        $words = str_word_count($excerpt, 2);
        if (count($words) > $length) {
            $words = array_slice($words, 0, $length, true);
            end($words);
            $position = key($words) + strlen(current($words));
            $excerpt = substr($excerpt, 0, $position) . $more;
        }
        return $excerpt;
    }
}
