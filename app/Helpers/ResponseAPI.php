<?php

function successResponse($message, $code)
{
    return response()->json([
        "success" => true,
        "code" => $code,
        "message" => $message,
    ], $code);
}

function errorResponse($message, $code, $errorDetails = null)
{
    return response()->json([
        "success" => false,
        "code" => $code,
        "message" => $message,
        "error" => $errorDetails,
    ], $code);
}