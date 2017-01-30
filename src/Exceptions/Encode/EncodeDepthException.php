<?php namespace Arcanedev\Json\Exceptions\Encode;

/**
 * Class     EncodeDepthException
 *
 * @package  Arcanedev\Json\Exceptions\Encode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EncodeDepthException extends EncodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'The maximum stack depth of :depth was exceeded.';
}
