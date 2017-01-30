<?php namespace Arcanedev\Json\Exceptions\Encode;

/**
 * Class     UnsupportedTypeException
 *
 * @package  Arcanedev\Json\Exceptions\Encode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UnsupportedTypeException extends EncodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'An unsupported value type was found an partial output is not enabled.';
}
