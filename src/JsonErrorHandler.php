<?php namespace Arcanedev\Json;

/**
 * Class     JsonErrorHandler
 *
 * @package  Arcanedev\Json
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class JsonErrorHandler
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Handled errors list.
     *
     * @var array
     */
    protected static $errors  = [
        'decode'  => [
            'default' => Exceptions\Decode\DecodeException::class,

            'handled' => [
                JSON_ERROR_DEPTH          => Exceptions\Decode\DecodeDepthException::class,
                JSON_ERROR_STATE_MISMATCH => Exceptions\Decode\StateMismatchException::class,
                JSON_ERROR_CTRL_CHAR      => Exceptions\Decode\ControlCharacterException::class,
                JSON_ERROR_SYNTAX         => Exceptions\Decode\SyntaxException::class,
                JSON_ERROR_UTF8           => Exceptions\Decode\UTF8Exception::class,
            ],
        ],

        'encode'  => [
            'default' => Exceptions\Encode\EncodeException::class,

            'handled' => [
                JSON_ERROR_DEPTH                 => Exceptions\Encode\EncodeDepthException::class,
                JSON_ERROR_RECURSION             => Exceptions\Encode\RecursionException::class,
                JSON_ERROR_INF_OR_NAN            => Exceptions\Encode\InfiniteOrNotANumberException::class,
                JSON_ERROR_UNSUPPORTED_TYPE      => Exceptions\Encode\UnsupportedTypeException::class,
                JSON_ERROR_INVALID_PROPERTY_NAME => Exceptions\Encode\InvalidPropertyNameException::class,
            ],
        ],
    ];

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the decode json errors.
     *
     * @param  int    $error
     * @param  int    $options
     * @param  array  $replaces
     *
     * @throws Exceptions\JsonException|Exceptions\Decode\DecodeException
     */
    public static function handleDecodeErrors($error, $options, array $replaces = [])
    {
        unset($options); // Use the unused argument

        throw self::makeException('decode', $error, $replaces);
    }

    /**
     * Handle the encode json errors.
     *
     * @param  int    $error
     * @param  int    $options
     * @param  array  $replaces
     *
     * @throws Exceptions\JsonException|Exceptions\Encode\EncodeException
     */
    public static function handleEncodeErrors($error, $options = 0, array $replaces = [])
    {
        if (($options & JSON_PARTIAL_OUTPUT_ON_ERROR) === 0)
            throw self::makeException('encode', $error, $replaces);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Make an exception.
     *
     * @param  string  $type
     * @param  int     $error
     * @param  array   $replaces
     *
     * @return Exceptions\JsonException|Exceptions\Decode\DecodeException|Exceptions\Encode\EncodeException
     */
    private static function makeException($type, $error, array $replaces = [])
    {
        /** @var  \Arcanedev\Json\Exceptions\JsonException  $ex */
        $ex = array_key_exists($error, self::$errors[$type]['handled'])
            ? new self::$errors[$type]['handled'][$error]
            : new self::$errors[$type]['default'];

        return $ex->replace($replaces);
    }
}
