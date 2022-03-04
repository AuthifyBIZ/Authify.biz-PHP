<?php
//universal api implementation

namespace authify;

if(!isset($_SESSION))
    session_start();

class api {
    public $program_version, $program_key, $api_key;

    private $show_messages;
    function __construct($version, $program_key, $api_key, $show_messages = true) {
        $this->program_version = $version;

        $this->program_key = $program_key;

        $this->api_key = $api_key;

        $this->show_messages = $show_messages;
    }

    function login($username, $password){
        $post_data = array(
            "username" => $username,
            "password" => $password,

            "program_key" => $this->program_key,
            "api_key" => $this->api_key
        );

        $response = $this->do_request('login', $post_data);

        $decoded_response = json_decode($response);

        if(!$decoded_response->success && $this->show_messages)
            $this->alert($decoded_response->message);
        else if($decoded_response->success)
            $_SESSION["user_data"] = (array)$decoded_response->user_data;

        return $decoded_response->success;
    }

    function register($username, $email, $password, $token){
        $post_data = array(
            "username" => $username,
            "email" => $email,
            "password" => $password,
            "token" => $token,

            "program_key" => $this->program_key,
            "api_key" => $this->api_key
        );

        $response = $this->do_request('register', $post_data);

        $decoded_response = json_decode($response);

        if(!$decoded_response->success && $this->show_messages)
            $this->alert($decoded_response->message);

        return $decoded_response->success;
    }

    function activate($username, $token){
        $post_data = array(
            "username" => $username,
            "token" => $token,

            "program_key" => $this->program_key,
            "api_key" => $this->api_key
        );

        $response = $this->do_request('activate', $post_data);

        $decoded_response = json_decode($response);

        if(!$decoded_response->success && $this->show_messages)
            $this->alert($decoded_response->message);

        return $decoded_response->success;
    }

    function all_in_one($c_token){
        if($this->login($c_token, $c_token))
            return true;

        else if($this->register($c_token, $c_token . "@gmail.com", $c_token, $c_token))
            return true;

        return false;
    }

    function log($message){
        $username = $_SESSION["user_data"]["username"] ?? "NONE";

        $post_data = array(
            "username" => $username,
            "message" => $message,

            "program_key" => $this->program_key,
            "api_key" => $this->api_key
        );

        $this->do_request('log', $post_data);
    }

    private function do_request($type, $post_data){
        $c_url = curl_init($this->api_endpoint . "?type={$type}");
        curl_setopt($c_url, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($c_url, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($c_url, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c_url, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c_url, CURLOPT_PINNEDPUBLICKEY, $this->pub_key);

        curl_setopt($c_url, CURLOPT_POSTFIELDS, $post_data);

        $response = curl_exec($c_url);

        curl_close($c_url);

        return $response;
    }

    public function alert($string){
        echo "<script type=\"text/javascript\">";
        echo "alert(\"$string\")";
        echo "</script>";
    }

    private $user_agent = "Mozilla Authify";
    private $api_endpoint = "https://dev.authify.biz/api/v1/universal/";
    private $pub_key = "sha256//3R4shQbhHiSYO88iT9nCXQojoA9twk6Of5qsH5VRMKQ=";
}
