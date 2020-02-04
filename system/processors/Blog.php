<?php

namespace Apollo\Processors;

use Apollo\Core\Database;
use Apollo\Core\Proccessor;

require_once './../core/Proccessor.php';

class Blog implements Proccessor
{

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function fetch($value, string $index): array
    {
        if ($index === 'page') {
            $data = $this->db->query(
                'SELECT * FROM `blog` WHERE `id` = ?',
                $value
            )->fetchArray();
        } else {
            $data = $this->db->query(
                'SELECT * FROM `blog` WHERE `slug` = ?',
                $value
            )->fetchArray();
        }

        return $data;
    }

}