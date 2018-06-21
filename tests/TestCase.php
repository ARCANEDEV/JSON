<?php namespace Arcanedev\Json\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\Json\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
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
