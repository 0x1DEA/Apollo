<?php

namespace Apollo\Core;

use DatabaseLoader;
use Exception;
use MatthiasMullie\Minify;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

require_once(SYS_DIR.'/vendor/twig/twig/src/Loader/DatabaseLoader.php');
require_once(SYS_DIR.'/vendor/autoload.php');

class Templates
{
    private Database $db;
    private DatabaseLoader $loader;
    private Environment $renderer;

    public function __construct(Database $db)
    {
        $this->loader   = new DatabaseLoader($db);
        $this->renderer = new Environment($this->loader);
    }

    /**
     * Caches CSS to a file
     *
     * @param  string  $name
     *
     * @throws Exception
     */
    public function cacheCSS(string $name)
    {
        $data = $this->db->query('SELECT FROM styles WHERE name = ?', $name)
                         ->fetchAll();
        $css  = '';
        for ($i = 0; $i < count($data); $i++) {
            $css .= $data[$i]['style'];
        }
        $minify = new Minify\CSS($css);

        file_put_contents(
            SYS_DIR.'./cache/'.$name.'/'.bin2hex(random_bytes(5)).'.template',
            $minify->minify()
        );
    }

    /**
     * Renders the template and send the page
     *
     * @param  string  $template
     *
     * @param  array  $args
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template, array $args)
    {
        echo $this->renderer->render($template, $args);
    }
}