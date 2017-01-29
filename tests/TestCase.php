<?php namespace Arcanedev\Json\Tests;

use PHPUnit_Framework_TestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\Json\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get fixture path
     *
     * @param  string  $path
     *
     * @return string
     */
    protected function getFixturesPath($path)
    {
        return __DIR__."/fixtures/$path";
    }
}
