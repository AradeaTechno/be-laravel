<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper {
    private static $map = [
        200 => "OK",
        201 => "Created",
        400 => "Bad request",
        401 => "Unauthorized",
        422 => "Unprocessable entity",
        403 => "Forbidden access",
        404 => "Not found",
        500 => "Internal server error"
    ];
    public static function create(int $status, $data=null, string $customMsg=""): JsonResponse {
        $msg = "No message";
        if(array_key_exists($status, self::$map)) {
            $msg = self::$map[$status];
        }
        if($customMsg) {
            $msg = $customMsg;
        }
        $resp = [
            "status" => $status,
            "message" => $msg,
        ];
        if($data) {
            $resp["data"] = $data;
        }
        return response()->json($resp, $status);
    }
}