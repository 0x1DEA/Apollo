<?php

namespace Apollo\Extensions;

use Apollo\Core\ErrorHandler;
use Apollo\Core\ExtensionBase;

class Comic extends ExtensionBase
{

    public static function getSubscribedEvents()
    {
        return array('loadRoutes' => 'addRoutes');
    }

    public function addRoutes($r)
    {
        $r->getRouter()->addRoute(
            'GET',
            '/comic/{name}',
            function ($vars) {
                global $templates, $pageData;

                $data = $this->fetch($vars['name'], 'comic');
                $this->handleResponse($data);
                $pageData['comic'] = $data;
                $templates->render('comic', $pageData);
            }
        );

        $r->getRouter()->addRoute(
            'GET',
            '/page/{id}',
            function ($vars) {
                global $templates, $pageData;

                $data = $this->fetch($vars['id'], 'page');
                $this->handleResponse($data);
                $pageData['comic'] = $data;
                $templates->render('comic', $pageData);
            }
        );
    }

    public function fetch($value, string $index): array
    {
        global $db;
        if ($index === 'page') {
            $data = $db->query(
                'SELECT * FROM `comics` WHERE `id` = ?',
                $value
            )->fetchArray();
        } else {
            $data = $db->query(
                'SELECT * FROM `comics` WHERE `slug` = ?',
                $value
            )->fetchArray();
        }

        return $data;
    }


    public function handleResponse(array $data) {
        global $templates, $pageData, $db, $handler;
        if (empty($data)) {
            $data = $db->query('SELECT * FROM `pages` WHERE `slug` = 404')->fetchArray();
            $pageData['page'] = $data;
            $templates->render('404', $pageData);
            if (empty($data)) {
                $handler->error(ErrorHandler::TEMPLATE_UNKNOWN);
            }
            exit();
        }
    }
}