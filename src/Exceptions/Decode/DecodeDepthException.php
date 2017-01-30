<?php namespace Arcanedev\Json\Exceptions\Decode;

/**
 * Class     DecodeDepthException
 *
 * @package  Arcanedev\Json\Exceptions\Decode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DecodeDepthException extends DecodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'The maximum stack depth of :depth was exceeded.';
}
