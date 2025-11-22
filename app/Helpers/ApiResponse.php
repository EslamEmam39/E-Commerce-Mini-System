<?php

namespace App\Helpers;

class ApiResponse{


    public static function success($data=null, $token=null, $message='success', $code=200 ){

     return response()->json(array_filter([
            "status"  => true,
            "message" => $message,
            "data"    => $data,
            "token"   => $token,   // سيُحذف تلقائيًا لو null
            "errors"  => null
        ], function ($value) {
            return !is_null($value); // احذف أي قيمة null
        }), $code);
    }
   

    public static function error($data=[], $message='error', $code= 500 ){

        return response()->json([
            "status" => false,
            "message" => $message,
            "data" => null,
            "errors" => $data,
        ] ,$code);
    }


}


