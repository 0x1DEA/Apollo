<?php

require_once 'LoaderInterface.php';

use Apollo\Core\Database;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

class DatabaseLoader implements LoaderInterface
{
    protected Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getSourceContext($name): Source
    {
        if (false === $source = $this->getValue('template', $name)) {
            throw new LoaderError(
                sprintf('Template "%s" does not exist.', $name)
            );
        }

        return new Source($source, $name);
    }

    public function exists($name)
    {
        return $name === $this->getValue('name', $name);
    }

    public function getCacheKey(string $name): string
    {
        return $name;
    }

    public function isFresh($name, $time): bool
    {
        if (false === $lastModified = $this->getValue('modified', $name)) {
            return false;
        }

        return $lastModified <= $time;
    }

    protected function getValue(string $column, string $name): string
    {
        global $apollo;
        $rows = 0;
        if ($apollo->theme !== '1') {
            $data = $this->db->query(
                'SELECT * FROM `templates` WHERE `title` = ? AND `theme` IN ("1") ORDER BY `theme` DESC',
                $name
            );
        } else {
            $data = $this->db->query(
                'SELECT * FROM `templates` WHERE `title` = ? AND `theme` IN ("1", ?) ORDER BY `theme` DESC',
                $name,
                $apollo->theme
            );
        }
        // TODO: edit query to only select value asked for
        if ($data->numRows() < 1) {
            // TODO: Template error
            return "row not found in templates table";
        } else {
            $data = $data->fetchArray();
                return $data[$column];
        }
    }
}