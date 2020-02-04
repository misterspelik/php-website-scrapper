<?php

namespace Scrapper;

use voku\helper\HtmlDomParser;
use Scrapper\Filesystem\Disk;

class Scrapper
{

    private $domain;

    private $disk;

    private static $instance = null;

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->disk = new Disk();
    }

    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }

    public function run()
    {
        $mainPage = HtmlDomParser::file_get_html($this->domain);

        mkdir('parsed', 0777);
        copy('.htaccess', 'parsed/.htaccess');
        file_put_contents('parsed/index.html', $mainPage);

        $links = $mainPage->findMulti('a[href*=posts]');

        $linksArray = get_object_vars($links);
        $linksPathes = array_map(function ($link) {
            return $link->getAttribute('href');
        }, $linksArray);

        $linksPathes = array_unique($linksPathes);

        foreach ($linksPathes as $path) {
            // $postName = substr($path, 7, 20);
            preg_match_all('!\d+!', $path, $matches);
            $pathName = $matches[0][0];
            if (!file_exists('parsed/posts')) {
                mkdir('parsed/posts', 0777, true);
            }
            file_put_contents('parsed/posts/' . $pathName . '.html', HtmlDomParser::file_get_html($this->domain . $path));
        }

    }
}