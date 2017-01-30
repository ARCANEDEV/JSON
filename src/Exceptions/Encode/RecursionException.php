<?php namespace Arcanedev\Json\Exceptions\Encode;

/**
 * Class     RecursionException
 *
 * @package  Arcanedev\Json\Exceptions\Encode
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RecursionException extends EncodeException
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $message = 'A recursive object was found and partial output is not enabled.';
}
