<?php namespace Arcanedev\Json\Exceptions\Decode;

/**
 * Class     StateMismatchException
 *
 * @package  Arcanedev\Json\Exceptions\Decode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StateMismatchException extends DecodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'The value is not JSON or is malformed.';
}
