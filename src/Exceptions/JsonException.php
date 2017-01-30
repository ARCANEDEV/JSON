<?php namespace Arcanedev\Json\Exceptions;

/**
 * Class     JsonException
 *
 * @package  Arcanedev\Json\Exceptions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class JsonException extends \Exception
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Replace message placeholders with replaces params.
     *
     * @param  array  $replaces
     *
     * @return self
     */
    public function replace(array $replaces = [])
    {
        foreach($replaces as $key => $value) {
            $this->message = str_replace(":$key", $value, $this->message);
        }

        return $this;
    }
}
