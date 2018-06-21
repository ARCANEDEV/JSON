<?php namespace Arcanedev\Json\Tests;

use Arcanedev\Json\Json;
use Arcanedev\Json\Exceptions;

/**
 * Class     JsonTest
 *
 * @package  Arcanedev\Support\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class JsonTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var \Arcanedev\Json\Json */
    private $json;

    /** @var string */
    private $fixturePath;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->fixturePath = $this->getFixturesPath('file-1.json');
        $this->json        = new Json($this->fixturePath);
    }

    public function tearDown()
    {
        unset($this->json);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        static::assertInstanceOf(Json::class, $this->json);

        static::assertEquals(
            $this->convertFixture($this->fixturePath),
            $this->json->toArray()
        );
    }

    /** @test */
    public function it_can_make()
    {
        $this->json = Json::make($this->fixturePath);

        static::assertInstanceOf(Json::class, $this->json);

        static::assertContains(
            (string) $this->json,
            $this->getFixtureContent($this->fixturePath)
        );

        static::assertEquals(
            $this->convertFixture($this->fixturePath),
            $this->json->toArray()
        );

        static::assertJson($this->json->toJson());
        static::assertJson(json_encode($this->json));
    }

    /** @test */
    public function it_can_instantiate_with_json_content()
    {
        $this->json = Json::fromContent('{"foo":"bar"}');

        static::assertSame(['foo' => 'bar'], $this->json->toArray());
    }

    /** @test */
    public function it_can_get_and_set_an_attribute()
    {
        $fixture = $this->convertFixture($this->fixturePath);

        static::assertEquals($fixture['name'], $this->json->get('name'));
        static::assertEquals($fixture['name'], $this->json->name);
        static::assertEquals($fixture['name'], $this->json->name());

        static::assertEquals($fixture['description'], $this->json->get('description'));
        static::assertEquals($fixture['description'], $this->json->description);
        static::assertEquals($fixture['description'], $this->json->description());

        static::assertNull($this->json->get('url', null));
        static::assertNull($this->json->url);
        static::assertNull($this->json->url());

        $url = 'https://www.github.com';
        $this->json->set('url', $url);

        static::assertEquals($url, $this->json->get('url'));
        static::assertEquals($url, $this->json->url);
        static::assertEquals($url, $this->json->url());
    }

    /** @test */
    public function it_can_set_and_get_path()
    {
        static::assertEquals($this->fixturePath, $this->json->getPath());

        $this->fixturePath = $this->getFixturesPath('file-2.json');
        $this->json->setPath($this->fixturePath);

        static::assertEquals($this->fixturePath, $this->json->getPath());
    }

    /** @test */
    public function it_can_save()
    {
        $path = $this->getFixturesPath('saved.json');

        static::assertNotFalse($this->json->setPath($path)->save());

        static::assertEquals(
            $this->getFixtureContent($path),
            $this->json->loadFile($path)
        );

        unlink($path);
    }

    /** @test */
    public function it_can_update()
    {
        $path = $this->getFixturesPath('saved.json');

        static::assertEquals(5, count($this->json->attributes()));

        $saved = $this->json->setPath($path)->save();

        static::assertNotFalse($saved);
        static::assertEquals(
            $this->getFixtureContent($path),
            $this->json->toJsonPretty()
        );

        $this->json->update(['url' => 'https://www.github.com']);
        static::assertEquals(6, count($this->json->attributes()));

        unlink($path);
    }

    /**
     * @test
     *
     * @expectedException         \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @expectedExceptionMessage  File does not exist at path /path/invalid.json
     */
    public function it_must_throw_a_file_not_found_exception_on_make_method()
    {
        Json::make('/path/invalid.json');
    }

    /** @test */
    public function it_can_encode()
    {
        static::assertSame(['test' => 123], Json::decode('{"test":123}'));

        $expected = new \stdClass;
        $expected->test = 123;

        static::assertEquals($expected, Json::decode('{"test":123}', false));
    }

    /**
     * @test
     *
     * @param  string  $json
     * @param  string  $class
     *
     * @dataProvider getDecodeExceptionsData
     */
    public function it_can_handle_decode_errors($json, $class, $message)
    {
        try {
            $this->json->decode($json, false, 0, 2);
        }
        catch (Exceptions\JsonException $ex) {
            static::assertInstanceOf($class, $ex);
            static::assertSame($message, $ex->getMessage());
        }
    }

    /**
     * Get the decode exceptions data.
     *
     * @return array
     */
    public function getDecodeExceptionsData()
    {
        return [
            // #0
            [
                '[[1]]',
                Exceptions\Decode\DecodeDepthException::class,
                'The maximum stack depth of 2 was exceeded.',
            ],
            // #1
            [
                '[1}',
                Exceptions\Decode\StateMismatchException::class,
                'The value is not JSON or is malformed.',
            ],
            // #2
            [
                '["'.chr(0).'test"]',
                Exceptions\Decode\ControlCharacterException::class,
                'An unexpected control character was found.',
            ],
            // #3
            [
                '[',
                Exceptions\Decode\SyntaxException::class,
                'The encoded JSON value has a syntax error.',
            ],
            // #4
            [
                '["'.chr(193).'"]',
                Exceptions\Decode\UTF8Exception::class,
                'The encoded JSON value contains invalid UTF-8 characters.',
            ],
        ];
    }

    /**
     * @test
     *
     * @param  mixed   $content
     * @param  string  $class
     * @param  string  $message
     *
     * @dataProvider getEncodeExceptionsData
     */
    public function it_can_handle_encode_errors($content, $class, $message)
    {
        try {
            $this->json->encode($content, 0, 5);
        }
        catch (Exceptions\JsonException $ex) {
            static::assertInstanceOf($class, $ex);
            static::assertSame($message, $ex->getMessage());
        }
    }

    /**
     * Get the encode exceptions data.
     *
     * @return array
     */
    public function getEncodeExceptionsData()
    {
        return [
            // #0
            [
                [[[[[[1]]]]]],
                Exceptions\Encode\EncodeDepthException::class,
                'The maximum stack depth of 5 was exceeded.',
            ],
            // #1
            [
                call_user_func(
                    function () {
                        $value = (object) [];
                        $value->value = $value;
                        return $value;
                    }
                ),
                Exceptions\Encode\RecursionException::class,
                'A recursive object was found and partial output is not enabled.',
            ],
            // #2
            [
                INF,
                Exceptions\Encode\InfiniteOrNotANumberException::class,
                'An INF or NAN value was found an partial output is not enabled.',
            ],
            // #3
            [
                STDIN,
                Exceptions\Encode\UnsupportedTypeException::class,
                'An unsupported value type was found an partial output is not enabled.',
            ]
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * @param  string $path
     *
     * @return string
     */
    private function getFixtureContent($path)
    {
        return file_get_contents($path);
    }

    /**
     * Convert fixture file to array
     *
     * @param  string  $path
     *
     * @return array
     */
    private function convertFixture($path)
    {
        return json_decode($this->getFixtureContent($path), JSON_PRETTY_PRINT);
    }
}
