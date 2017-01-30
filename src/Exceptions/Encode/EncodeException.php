<?php namespace Arcanedev\Json\Exceptions\Encode;

use Arcanedev\Json\Exceptions\JsonException;

/**
 * Class     EncodeException
 *
 * @package  Arcanedev\Json\Exceptions\Encode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EncodeException extends JsonException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'An unrecognized encoding error was encountered: :last_error_msg';
}
