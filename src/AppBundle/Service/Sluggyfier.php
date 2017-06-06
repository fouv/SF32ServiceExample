<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 06/06/17
 * Time: 11:08
 */

namespace AppBundle\Service;


use Monolog\Logger;

class Sluggyfier
{
    /**
     * example param, not very usefull
     * @var  Logger
     */
    private $logger;

    /** @var  integer */
    private $max;

    /**
     * Sluggyfier constructor.
     * @param Logger $logger
     * @param $max
     */
    public function __construct(Logger $logger, $max)
    {
        $this->setLogger($logger);
        $this->max = $max;
    }

    /**
     * @param Logger $logger
     * @return $this
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param $text
     * @return bool|mixed|string
     */
    public function slug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return false;
        }
        $this->getLogger()->log("INFO", "new slug  " . $text . "(" . $this->max . ")");
        return $text;
    }
}