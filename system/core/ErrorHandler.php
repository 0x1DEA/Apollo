<?php

namespace Apollo\Core;

class ErrorHandler
{

    /**
     * Returns an HTTP code
     *
     * @param  string  $code
     */
    public function http(string $code)
    {
        $this->output(Error::HTTP(), $code);
    }

    /**
     * Receives an error with an optional argument
     *
     * @param  Error  $error
     * @param  string  $arg
     */
    public function error(Error $error, string $arg = null)
    {
        if ($error === Error::HTTP()) {
            $this->http($arg);
        } else {
            $this->output($error);
        }
    }

    public function output(Error $code, int $http = null)
    {
        $name = $code;
        if ( ! is_null($http)) {
            http_response_code($http);
            $page = "
        <!doctype html>
        <html>
        <head>
            <title>HTTP {$name}</title>
        </head>
        <body>
        <div>
        <p>HTTP ERROR {$name}. Uh oh! Maybe try something else...</p>
        </div>
        </body>
        </html>
        ";
        } else {
            http_response_code(503);
            header("Content-type: text/html; charset=UTF-8");
            $page = "
        <!doctype html>
        <html>
        <head>
            <title>System Error {$name}</title>
        </head>
        <body>
        <div>
        <p>We regret to inform you that Apollo has suffered an unrecoverable error {$name}. Refresh the page to try again.</p>
        </div>
        </body>
        </html>
        ";
        }

        die($page);
    }
}