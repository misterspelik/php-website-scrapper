<?php

namespace Scrapper\Cli;

class Input
{
    private static $cli_agruments = [
        "domain:",
    ];

    /**
     * Gets expression from input
     * (--domain="domain here")
     * @return string | null
     */
    public static function getDomain() : ?string
    {
        $options = getopt("", self::$cli_agruments);

        return !empty($options['domain']) ? $options['domain'] : null;
    }
}