<?php

namespace Apollo\Core;

class ErrorHandler
{

    public const TEMPLATE_SYNTAX = 'Template Syntax Error';
    public const TEMPLATE_RUNTIME = 'Template Runtime Error';
    public const TEMPLATE_LOADER = 'Template Loader Error';
    public const TEMPLATE_MISSING = 'Missing Template Error';

    /**
     * Receives an error with an optional argument
     *
     * @param  $error
     */
    public function error($error)
    {
        $this->output($error);
    }

    public function notFound() {
        // TODO: Prevent potential redirect loop caused by missing 404 page/template
        header("Location: /404");
        exit();
    }

    private function output($code)
    {
        http_response_code(503);
        header("Content-type: text/html; charset=UTF-8");
        $page = "
        <!doctype html>
        <html>
        <head>
            <title>System Error {$code}</title>
        </head>
        <body>
        <div>
        <p>We regret to inform you that Apollo has suffered an unrecoverable error <code>{$code}</code>. Refresh the page to try again.</p>
        </div>
        </body>
        </html>
        ";
        die($page);
    }
}