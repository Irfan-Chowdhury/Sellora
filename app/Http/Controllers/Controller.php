<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    public function setSuccessMessage($message): void
	{
        session()->flash('message',$message);
        session()->flash('type','success');
	}

	public function setErrorMessage($message): void
	{
        session()->flash('message',$message);
		session()->flash('type','danger');
	}


    public function sendResponse($message = null, $result = null)
    {
    	$response = [
            'success' => true,
            'result'  => $result,
        ];

        if($message){
            $response['message'] = $message;
        }

        return response()->json($response, 200);
    }

    public function sendError($errorMessage, $code = 500)
    {
    	$response = [
            'success' => false,
            'errorMessage' => $errorMessage,
        ];

        // if(!empty($errorMessages)){
        //     $response['errors'] = $errorMessages;
        // }

        return response()->json($response, $code);
    }



    public function successResponse(string $message, object|array $result, int $code = 200)
    {
        $response = [
            'statusCode' => $code,
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, $code);
    }

    public function errorResponse(string|array $message, int $statusCode = 500)
    {
        $response = [
            'statusCode' => $statusCode,
            'success' => false,
            'message' => self::statusCodeToMessage($statusCode) ?? 'Server Error',
            'errors' => ['message' => [$message]],
        ];

        return response()->json($response, $statusCode);
    }

    public function statusCodeToMessage(int $statusCode): string
    {
        return match ($statusCode) {
            200 => 'OK',
            201 => 'Created successfully',
            202 => 'Accepted but processing not completed',
            204 => 'No content',

            400 => 'Bad Request',
            401 => 'Authentication required',
            403 => 'Forbidden',
            404 => 'Resource not found',
            405 => 'Method not allowed',
            409 => 'Conflict occurred',
            422 => 'Validation Error',

            429 => 'Too many requests',

            500 => 'Server Error',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',

            default => 'Unknown Error',
        };
    }
}
