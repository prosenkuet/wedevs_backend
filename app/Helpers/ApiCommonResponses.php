<?php


namespace App\Helpers;


class ApiCommonResponses
{
    protected $error_success = false;
    protected $success_success = true;
    protected $error_code = 1003;
    protected $success_code = 1000;
    protected $message = "Something Went Wrong.";
    protected $status_code = 200;

    public function __construct()
    {
    }

    public function successCode($success_code)
    {
        $this->success_code = $success_code;
        return $this;
    }

    public function message($message){
        $this->message = $message;
        return $this;
    }

    public function successResponse($additional_response = []){
        return response()->json(array_merge(
            array(
                "success" => $this->success_success,
                "code" => $this->success_code,
                "message" => $this->message
            ),
            $additional_response
        ), $this->status_code);
    }

}
