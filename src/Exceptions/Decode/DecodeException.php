<?php namespace Arcanedev\Json\Exceptions\Decode;

use Arcanedev\Json\Exceptions\JsonException;

/**
 * Class     DecodeException
 *
 * @package  Arcanedev\Json\Exceptions\Decode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DecodeException extends JsonException
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var string */
    protected $message = 'An unrecognized decoding error was encountered: :last_error_msg';
}
