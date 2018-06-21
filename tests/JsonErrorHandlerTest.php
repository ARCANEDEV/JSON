<?php namespace Arcanedev\Json\Tests;

use Arcanedev\Json\Exceptions;
use Arcanedev\Json\JsonErrorHandler;

/**
 * Class     JsonErrorHandlerTest
 *
 * @package  Arcanedev\Json\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class JsonErrorHandlerTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /**
     * @test
     *
     * @dataProvider getDecodeExceptionsData
     *
     * @param  int     $error
     * @param  string  $class
     * @param  int     $options
     * @param  array   $replaces
     * @param  string  $msg
     */
    public function it_can_handle_decode_exceptions($error, $class, $options, array $replaces, $msg)
    {
        try {
            JsonErrorHandler::handleDecodeErrors($error, $options, $replaces);
        }
        catch (\Exception $ex) {
            static::assertInstanceOf($class, $ex);
            static::assertSame($msg, $ex->getMessage());
        }
    }

    /**
     * Provide encode exceptions data for tests.
     *
     * @return array
     */
    public function getDecodeExceptionsData()
    {
        return [
            // #0
            [
                JSON_ERROR_DEPTH,
                Exceptions\Decode\DecodeDepthException::class,
                0,
                ['depth' => 123],
                'The maximum stack depth of 123 was exceeded.',
            ],
            // #1
            [
                JSON_ERROR_STATE_MISMATCH,
                Exceptions\Decode\StateMismatchException::class,
                0,
                [],
                'The value is not JSON or is malformed.',
            ],
            // #2
            [
                JSON_ERROR_CTRL_CHAR,
                Exceptions\Decode\ControlCharacterException::class,
                0,
                [],
                'An unexpected control character was found.',
            ],
            // #3
            [
                JSON_ERROR_SYNTAX,
                Exceptions\Decode\SyntaxException::class,
                0,
                [],
                'The encoded JSON value has a syntax error.',
            ],
            // #4
            [
                JSON_ERROR_UTF8,
                Exceptions\Decode\UTF8Exception::class,
                0,
                [],
                'The encoded JSON value contains invalid UTF-8 characters.',
            ],
            // #5
            [
                999,
                Exceptions\Decode\DecodeException::class,
                0,
                ['last_error_msg' => 'Unexpected json decode error.'],
                'An unrecognized decoding error was encountered: Unexpected json decode error.',
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider getEncodeExceptionsData
     *
     * @param  int     $error
     * @param  string  $class
     * @param  int     $options
     * @param  array   $replaces
     * @param  string  $msg
     */
    public function it_can_handle_encode_exceptions($error, $class, $options = 0, array $replaces, $msg)
    {
        try {
            JsonErrorHandler::handleEncodeErrors($error, $options, $replaces);
        }
        catch (\Exception $ex) {
            static::assertInstanceOf($class, $ex);
            static::assertSame($msg, $ex->getMessage());
        }
    }

    /**
     * Provide encode exceptions data for tests.
     *
     * @return array
     */
    public function getEncodeExceptionsData()
    {
        return [
            // #0
            [
                JSON_ERROR_DEPTH,
                Exceptions\Encode\EncodeDepthException::class,
                0,
                ['depth' => 321],
                'The maximum stack depth of 321 was exceeded.',
            ],
            // #1
            [
                JSON_ERROR_RECURSION,
                Exceptions\Encode\RecursionException::class,
                0,
                [],
                'A recursive object was found and partial output is not enabled.',
            ],
            // #2
            [
                JSON_ERROR_INF_OR_NAN,
                Exceptions\Encode\InfiniteOrNotANumberException::class,
                0,
                [],
                'An INF or NAN value was found an partial output is not enabled.',
            ],
            // #3
            [
                JSON_ERROR_UNSUPPORTED_TYPE,
                Exceptions\Encode\UnsupportedTypeException::class,
                0,
                [],
                'An unsupported value type was found an partial output is not enabled.',
            ],
            // #4
            [
                JSON_ERROR_INVALID_PROPERTY_NAME,
                Exceptions\Encode\InvalidPropertyNameException::class,
                0,
                [],
                'The value contained a property with an invalid JSON key name.',
            ],
            // #5
            [
                999,
                Exceptions\Encode\EncodeException::class,
                0,
                ['last_error_msg' => 'Unexpected json encode error.'],
                'An unrecognized encoding error was encountered: Unexpected json encode error.',
            ],
        ];
    }
}
