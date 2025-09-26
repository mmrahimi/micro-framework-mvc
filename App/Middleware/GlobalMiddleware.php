<?php

namespace App\Middleware;

use App\Middleware\Contract\MiddlewareContract;

class GlobalMiddleware Implements MiddlewareContract
{
    public function handle(): void
    {
        $this->sanitizeGetParams();
    }

    private function sanitizeGetParams(): void
    {
        foreach ($_GET as $key => $value)
        {
            $_GET[$key] = filter_var(htmlspecialchars($value), FILTER_SANITIZE_STRING);
        }
    }
}
