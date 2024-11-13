<?php

namespace App\Components\Helpers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ResponseHelper {

    public static function sendResponse($result = [], $message = '', $withData = true, $additionals = [], $success = true)
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        $arrResult = !is_array($result) ? $result->toArray() : $result;

        if(array_key_exists('current_page', $arrResult)){
            $response = array_merge($response,$arrResult);
        }else{
            $response['data'] = $arrResult;
        }

        // Change to Object if Array Empty
        if(empty($arrResult)) $response['data'] = (array) $arrResult;

        if(!$withData) unset($response['data']);

        // Additional
        if(!empty($additionals)){
            $response = array_merge($response, $additionals);
        }

        return response()->json($response, 200);
    }

    public static function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'code' => $code
        ];

        if(!empty($errorMessages)){
            if($errorMessages instanceof ValidationException){
                $response['message'] = trans('Please check your input again.');
                $response['errors'] = collect($errorMessages->errors());
            }else{
                if ( method_exists($errorMessages, 'getMessage') && is_callable([$errorMessages, 'getMessage'])) {
                    $response['message'] = $errorMessages->getMessage();
                } else {
                    $response['message'] = $errorMessages;
                }

            }

        }

        return response()->json($response, $code);
    }

    public static function getError($text = null)
    {
        return request()->expectsJson() ? self::sendError(@$text ?? 'You don\'t have permission to access this request') : abort(404);
    }

}