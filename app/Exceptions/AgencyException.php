<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgencyException extends Exception
{
    public function render(Request $request):JsonResponse {
        return response()->json([
            'message' => $this->getMessage(),
            'success' => false
        ], $this->getCode());
    }
}
