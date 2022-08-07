<?php

if (!function_exists("jsend_error")) {
    /**
     * @param string $message Error message
     * @param string $code Optional custom error code
     * @param string | array $data Optional data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_error($message, $code = null, $cause = null, $status = 500, $extraHeaders = [])
    {
        return response()->json(
            [
                "status" => "false",
                "message" => $message,
                'code' => is_null($code) ? 500 : $code,
                'cause' => is_null($cause) ? [] : $cause
            ],
            $status,
            $extraHeaders
        );
    }
}
if (!function_exists("jsend_fail")) {
    /**
     * @param array $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_fail($data, $status = 400, $extraHeaders = [])
    {
        $response = [
            "status" => "fail",
            "data" => $data
        ];

        #$extraHeaders['Authorization'] = app('Context')->getJwt();
        $extraHeaders['AuthorizationSas'] = null;

        return response()->json($response, $status, $extraHeaders);
    }
}
if (!function_exists("jsend_success")) {
    /**
     * @param array | Illuminate\Database\Eloquent\Model $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_success($data = [], $status = 200, $extraHeaders = [])
    {
        $response = [
            "status" => "success",
            "data" => $data
        ];
        #NO usar Authorization si esta trabajando con el mismo POSTMAN del gateway, se pisan
        #$extraHeaders['Authorization'] = app('Context')->getJwt();
        #return response()->json($response, $status, $extraHeaders)->cookie('Authorization', app('Context')->getJwt(), 60, '/', '.qubit.tv');

        $extraHeaders['AuthorizationSas'] = null;

        return response()->json($response, $status, $extraHeaders)->cookie('AuthorizationSas', null, 60, '/', '.qubit.tv');
    }
}
