<?php namespace Arcanedev\Json\Exceptions\Encode;

/**
 * Class     InfiniteOrNotANumberException
 *
 * @package  Arcanedev\Json\Exceptions\Encode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InfiniteOrNotANumberException extends EncodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'An INF or NAN value was found an partial output is not enabled.';
}
