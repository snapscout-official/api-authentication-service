<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class AuthenticationException extends Exception
{
    public function render(Request $request)
    {
        return response()->json([
            'error' => $this->getMessage(),
            'success' => false
        ], $this->getCode());
    }
}
