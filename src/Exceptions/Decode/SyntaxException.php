<?php namespace Arcanedev\Json\Exceptions\Decode;

/**
 * Class     SyntaxException
 *
 * @package  Arcanedev\Json\Exceptions\Decode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SyntaxException extends DecodeException
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var string */
    protected $message = 'The encoded JSON value has a syntax error.';
}
