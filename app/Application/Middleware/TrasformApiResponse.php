<?php

namespace Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrasformApiResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $success = (bool) $response->isSuccessful();
        $error = null;
        $content = json_decode($response->getContent(), true);

        if (!$success) {
            if (isset($content['errors'])) {
                $error = $this->processErrors($content['errors']);
            } else {
                $message = $content['message'] ?? 'Произошла ошибка';
                $field = $content['field'] ?? $this->extractFieldFromMessage($message);
                $error = [
                    'fields' => [
                        [
                            'field' => $field,
                            'message' => $message
                        ]
                    ]
                ];
            }
        }

        $content = $content['data'] ?? $content ?? [];

        $response->setContent(json_encode(
            $this->wrap($success, $content, $error)
        ));

        return $response;
    }

    public function wrap($success, $content, $error)
    {
        $wrapped = ['success' => $success];

        if ($error) {
            $wrapped['error'] = $error;
        } else {
            $wrapped['data'] = $content;
        }

        return $wrapped;
    }

    public function processErrors(array $errors)
    {
        $fields = [];
        foreach ($errors as $field => $messages) {
            if (is_array($messages)) {
                $message = $messages[0] ?? 'Неверное значение';
            } else {
                $message = $messages;
            }
            
            $fields[] = [
                'field' => $field,
                'message' => $message
            ];
        }

        return [
            'fields' => $fields
        ];
    }

    private function extractFieldFromMessage(string $message): string
    {
        $fieldMap = [
            'password' => ['password', 'пароль'],
            'login' => ['login', 'логин'],
            'email' => ['email', 'почта'],
        ];

        foreach ($fieldMap as $field => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($message, $keyword) !== false) {
                    return $field;
                }
            }
        }

        return 'general';
    }
}
