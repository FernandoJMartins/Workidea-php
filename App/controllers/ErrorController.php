<?php

namespace App\Controllers;


class ErrorController {

    /**
     * 404 not found error
     *
     * @param string $msg
     * @return void
     */
    public static function notFound($msg = "Resource not found"){
        http_response_code(404);

        loadView('error', [
            'status' => '404',
            'msg' => $msg
        ]);
    }

    /**
     * 403 unauthorized error
     *
     * @param string $msg
     * @return void
     */
    public static function unauthorized($msg = "You are not authorized to view this resource"){
        http_response_code(403);

        loadView('error', [
            'status' => '403',
            'message' => $msg
        ]);
    }

}