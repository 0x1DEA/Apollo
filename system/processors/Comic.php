<?php

namespace Apollo\Processors;

use Apollo\Core\Database;

class Comic
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
                'SELECT * FROM `comics` WHERE `id` = ?',
                $value
            )->fetchArray();
        } else {
            $data = $this->db->query(
                'SELECT * FROM `comics` WHERE `slug` = ?',
                $value
            )->fetchArray();
        }

        return $data;
    }

}