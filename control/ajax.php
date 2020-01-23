<?php
// TEMPORARY FILE
// TODO: Implement unique backend objects and classes
define('FEBRUARY', 1);
require_once './../system/config.php';
require_once SYS_DIR.'/core/Database.php';

use Apollo\Core\Database;

$db = new Database(DB_CREDENTIALS);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['templateSave'])) {
        $db->query(
            'UPDATE `templates` SET `version` = `version` + 1, `modified` = ?, `template` = ? WHERE `theme` = ? AND `title` = ? AND `templateGroup` = ?',
            time(),
            $_POST['templateData'],
            $_POST['themeNumber'],
            $_POST['templateName'],
            $_POST['groupNumber']
        );
    } elseif (isset($_POST['newPage'])) {
        $db->query(
            'INSERT INTO `templates` (`title`, `slug`, `description`, `template`) VALUES (?, ?, ?, ?)',
            $_POST['pageTitle'],
            $_POST['pageDescription'],
            $_POST['pageSlug'],
            $_POST['pageTemplate']
        );
    } elseif (isset($_POST['newGroup'])) {
        $db->query(
            'INSERT INTO `templategroups` (`name`, `title`, `description`) VALUES (?, ?, ?)',
            $_POST['groupName'],
            $_POST['groupTitle'],
            $_POST['groupDescription']
        );
    } elseif (isset($_POST['newTemplate'])) {
        $db->query(
            'INSERT INTO `templates` (`title`, `modified`, `theme`, `templategroup`) VALUES (?, ?, ?, ?)',
            $_POST['templateName'],
            time(),
            $_POST['themeNumber'],
            $_POST['templateGroup']
        );
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['getList'])) {
        switch ($_GET['type']) {
            case 1:
                $data = $db->query(
                    'SELECT * FROM `themes`'
                );
                break;
            case 2:
                $data = $db->query(
                    'SELECT * FROM `templategroups`'
                );
                break;
            case 3:
                $data = $db->query(
                    'SELECT * FROM `templates` WHERE `theme` = ? AND `templategroup` = ? ORDER BY `theme` DESC',
                    $_GET['theme'],
                    $_GET['group']
                );
                break;
        }
        $data = $data->fetchAll();
        if ($_GET['type'] == 1) {
            $list = $data[0]['id'];
        } elseif ($_GET['type'] == 2) {
            $list = $data[0]['id'];
        } else {
            $list = $data[0]['title'];
        }

        for ($i = 1; $i < count($data); $i++) {
            if ($_GET['type'] == 1) {
                $list .= ','.$data[$i]['id'];
            } elseif ($_GET['type'] == 2) {
                $list .= ','.$data[$i]['id'];
            } else {
                $list .= ','.$data[$i]['title'];
            }
        }
        echo $list;
    } elseif (isset($_GET['getData'])) {
        $data = $db->query(
            'SELECT * FROM `templates` WHERE `title` = ? AND `theme` = ? ORDER BY `theme` DESC',
            $_GET['template'],
            $_GET['theme']
        )->fetchArray();
        echo $data['template'];
    }
} else {
    //header("HTTP/1.1 400 Bad Request");
    echo 'Bad Request';
}