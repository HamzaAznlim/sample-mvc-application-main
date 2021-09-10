<?php


namespace app;

class Request
{
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function is_Get()
    {
        return $this->method() === 'get';
    }
    
    public function is_Post()
    {
        return $this->method() === 'post';
    }


    public function redirect(string $url)
    {
        header("Location: ".$url."");
        die();
    }


    public function req_Body()
    {
        $_Data = [];

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $_Data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $_Data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $_Data;
    }


    public function req_post()
    {
        return [...array_values($this->req_Body())];
    }
}
