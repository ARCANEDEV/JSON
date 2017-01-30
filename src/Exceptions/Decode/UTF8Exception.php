<?php namespace Arcanedev\Json\Exceptions\Decode;

/**
 * Class     UTF8Exception
 *
 * @package  Arcanedev\Json\Exceptions\Decode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UTF8Exception extends DecodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'The encoded JSON value contains invalid UTF-8 characters.';
}
