<?php namespace Arcanedev\Json;

use Arcanedev\Json\Contracts\Json as JsonContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use JsonSerializable;

/**
 * Class     Json
 *
 * @package  Arcanedev\Support
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Json implements JsonContract, Arrayable, Jsonable, JsonSerializable
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The file path.
     *
     * @var string
     */
    protected $path;

    /**
     * The laravel filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The attributes collection.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $attributes;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Construct the Json instance.
     *
     * @param  string                             $path
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     */
    public function __construct($path, Filesystem $filesystem = null)
    {
        $this->setFilesystem($filesystem ?: new Filesystem);
        $this->loadFile($path);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Set the filesystem instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     *
     * @return static
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path.
     *
     * @param  mixed  $path
     *
     * @return static
     */
    public function setPath($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    /**
     * Get file contents as Collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Decode ths json content.
     *
     * @param  string  $content
     * @param  bool    $assoc
     * @param  int     $depth
     * @param  int     $options
     *
     * @return array
     */
    public static function decode($content, $assoc = true, $options = 0, $depth = 512)
    {
        $decoded = json_decode($content, $assoc, $depth, $options);

        // Check if json decode has errors
        if (($lastError = json_last_error()) !== JSON_ERROR_NONE)
            JsonErrorHandler::handleDecodeErrors($lastError, $options, [
                'depth'             => $depth,
                'last_error_msg'    => json_last_error_msg(),
                'last_error_number' => $lastError,
            ]);

        return $decoded;
    }

    /**
     * Encode to json content.
     *
     * @param  mixed  $content
     * @param  int    $options
     * @param  int    $depth
     *
     * @return string
     */
    public function encode($content, $options = 0, $depth = 512)
    {
        $encoded = json_encode($content, $options, $depth);

        // Check if json encode has errors
        if (($lastError = json_last_error()) !== JSON_ERROR_NONE)
            JsonErrorHandler::handleEncodeErrors($lastError, $options, [
                'depth'             => $depth,
                'last_error_msg'    => json_last_error_msg(),
                'last_error_number' => $lastError,
            ]);

        return $encoded;
    }

    /**
     * Make new instance.
     *
     * @param  string                             $path
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     *
     * @return static
     */
    public static function make($path = null, Filesystem $filesystem = null)
    {
        return new static($path, $filesystem);
    }

    /**
     * Load json content.
     *
     * @param  string  $content
     *
     * @return static
     */
    public static function fromContent($content)
    {
        return static::make()->loadContent($content);
    }

    /**
     * Load the json file.
     *
     * @param  string  $path
     *
     * @return static
     */
    public function loadFile($path)
    {
        $content = '{}';

        if ( ! is_null($path)) {
            $this->setPath($path);

            $content = $this->filesystem->get($this->getPath());
        }

        return $this->loadContent($content);
    }

    /**
     * Load the json content.
     *
     * @param  string  $content
     *
     * @return static
     */
    public function loadContent($content)
    {
        $this->attributes = Collection::make(
            $this->decode($content)
        );

        return $this;
    }

    /**
     * Get the specified attribute from json file.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->attributes->get($key, $default);
    }

    /**
     * Set a specific key & value.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return static
     */
    public function set($key, $value)
    {
        $this->attributes->put($key, $value);

        return $this;
    }

    /**
     * Merge json attributes with a given array items.
     *
     * @param  array  $items
     *
     * @return static
     */
    public function merge(array $items)
    {
        $this->attributes = $this->attributes->merge($items);

        return $this;
    }

    /**
     * Update & save json contents from array items.
     *
     * @param  array   $items
     * @param  string  $path
     *
     * @return int
     */
    public function update(array $items, $path = null)
    {
        return $this->merge($items)->save($path);
    }

    /**
     * Save the current attributes array to the file storage.
     *
     * @param  string|null  $path
     *
     * @return int
     */
    public function save($path = null)
    {
        return $this->filesystem->put($path ?: $this->getPath(), $this->toJsonPretty());
    }

    /**
     * Handle call to __call method.
     *
     * @param  string  $method
     * @param  array   $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments = [])
    {
        if ( ! method_exists($this, $method)) {
            $arguments = [$method];
            $method    = 'get';
        }

        return call_user_func_array([$this, $method], $arguments);
    }

    /**
     * Handle magic method __get.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Handle call to __toString method.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJsonPretty();
    }

    /**
     * Convert the given array data to pretty json.
     *
     * @param  array  $data
     *
     * @return string
     */
    public function toJsonPretty(array $data = null)
    {
        return static::encode($data ?: $this->attributes, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes()->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return static::encode($this->toArray(), $options);
    }

    /**
     * Allow to encode the json object to json file.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
