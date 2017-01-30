<?php namespace Arcanedev\Json\Contracts;

use Illuminate\Filesystem\Filesystem;

/**
 * Interface  Json
 *
 * @package   Arcanedev\Json\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Json
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set the filesystem instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     *
     * @return self
     */
    public function setFilesystem(Filesystem $filesystem);

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Set path.
     *
     * @param  mixed  $path
     *
     * @return self
     */
    public function setPath($path);

    /**
     * Get file contents as Collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function attributes();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
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
    public static function decode($content, $assoc = true, $options = 0, $depth = 512);

    /**
     * Encode to json content.
     *
     * @param  mixed  $content
     * @param  int    $options
     * @param  int    $depth
     *
     * @return string
     */
    public function encode($content, $options = 0, $depth = 512);

    /**
     * Make new instance.
     *
     * @param  string                             $path
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     *
     * @return static
     */
    public static function make($path, Filesystem $filesystem = null);

    /**
     * Load json content.
     *
     * @param  string  $content
     *
     * @return static
     */
    public static function fromContent($content);

    /**
     * Get the specified attribute from json file.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Set a specific key & value.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function set($key, $value);

    /**
     * Merge json attributes with a given array items.
     *
     * @param  array  $items
     *
     * @return self
     */
    public function merge(array $items);

    /**
     * Update & save json contents from array items.
     *
     * @param  array   $items
     * @param  string  $path
     *
     * @return int
     */
    public function update(array $items, $path = null);

    /**
     * Save the current attributes array to the file storage.
     *
     * @param  string|null  $path
     *
     * @return int
     */
    public function save($path = null);

    /**
     * Convert the given array data to pretty json.
     *
     * @param  array  $data
     *
     * @return string
     */
    public function toJsonPretty(array $data = null);
}
