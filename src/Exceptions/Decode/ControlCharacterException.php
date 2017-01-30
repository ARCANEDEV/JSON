<?php namespace Arcanedev\Json\Exceptions\Decode;

/**
 * Class     ControlCharacterException
 *
 * @package  Arcanedev\Json\Exceptions\Decode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ControlCharacterException extends DecodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'An unexpected control character was found.';
}
