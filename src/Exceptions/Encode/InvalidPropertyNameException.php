<?php namespace Arcanedev\Json\Exceptions\Encode;

/**
 * Class     InvalidPropertyNameException
 *
 * @package  Arcanedev\Json\Exceptions\Encode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InvalidPropertyNameException extends EncodeException
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var string */
    protected $message = 'The value contained a property with an invalid JSON key name.';
}
