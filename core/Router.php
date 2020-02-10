<?php

namespace Apollo\Core;

use FastRoute\Dispatcher;

use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Router
{

    /**
     * @var
     */
    private $dispatcher;
    /**
     * @var array
     */
    public array $path;
    /**
     * @var mixed|string
     */
    public string $uri;
    /**
     * @var Apollo
     */
    public Apollo $apollo;

    /**
     * Router constructor.
     *
     * @param  Apollo  $apollo
     */
    public function __construct(Apollo $apollo)
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->path = explode("/", $this->uri);
        $this->apollo = $apollo;
    }

    /**
     *
     */
    public function register() {
        $this->dispatcher = simpleDispatcher(
            function (RouteCollector $r) {
                global $eventHandler;
                $eventHandler->dispatch(new \Apollo\Events\loadRoutes($r), 'loadRoutes');
                $r->addRoute(
                    'GET',
                    '/{page}',
                    function ($vars) {
                        global $templates, $pageData, $db, $handler;

                        $data = $db->query('SELECT * FROM `pages` WHERE `slug` = ?', $vars['page'])->fetchArray();

                        if (empty($data)) {
                            $data = $db->query('SELECT * FROM `pages` WHERE `slug` = 404')->fetchArray();
                            if (empty($data)) {
                                $handler->error(ErrorHandler::TEMPLATE_UNKNOWN);
                            }
                        }
                        $template         = $data['template'];
                        $pageData['page'] = $data;
                        $templates->render($template, $pageData);
                    }
                );
            }
        );
    }

    /**
     *
     */
    public function dispatch() {
        $routeInfo = $this->dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // This case shouldn't work because of the default page behavior
                $this->apollo->handler->notFound();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $this->apollo->handler->error(ErrorHandler::INVALID_METHOD);
                break;
            case Dispatcher::FOUND:
                $call = $routeInfo[1];
                $vars = $routeInfo[2];
                call_user_func($call, $vars);
                break;
        }
    }
}