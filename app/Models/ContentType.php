<?php

namespace App\Models;

use Exception;

/**
 * If adding additional content types, take a look at: http://www.iana.org/assignments/media-types/media-types.xhtml
 *
 * For the types to be recognised by your IDE,
 * it is recommended if adding additional content types, to add the method in the PHPDocs.
 *
 * Usage example: ContentType::get()->APP_JSON();
 *
 * @method ContentType TEXT_HTML
 * @method ContentType TEXT_XML
 * @method ContentType APP_JSON
 * @method ContentType APP_URLENCODED
 */
class ContentType
{
    /** @var array|string[] $types */
    private array $types = [
        "TEXT_HTML" => "text/html",
        "TEXT_XML" => "text/xml",
        "APP_JSON" => "application/json",
        "APP_URLENCODED" => "application/x-www-form-urlencoded;charset=UTF-8",
    ];

    /** @var string|mixed|null $type */
    protected string|null $type = null;

    /**
     * Sets the current type.
     *
     * @throws Exception
     */
    public function __construct(string $type = null, bool $key = false)
    {
        // Checks if there needs to be searched on key value.
        if (!$key) {
            // Sets the type if it is not a key value.
            $this->type = $type;
        } else {
            // Searches for the content type based on the key.
            // If not found throws an exception that the key doesn't exist.
            $this->type = $this->types[$type] ??
                throw new Exception("Content type doesn't exist or isn't known by ContentType!");
        }
        // Goes over all internal types, and adds the function to it that sets the correct value and returns this.
        foreach ($this->types as $type => $value) {
            $this->$type = function () use ($value) {
                $this->type = $value;
                return $this;
            };
        }
    }

    /**
     * Filters the call for the type method,
     * and executes the function connected to it.
     *
     *
     * @param $function
     * @param $args
     * @return mixed
     */
    public function __call($function, $args)
    {
        return call_user_func_array($this->{$function}->bindTo($this), $args);
    }

    /**
     * Returns a new instance of itself.
     *
     * @return static
     */
    public static function get(): self
    {
        return new ContentType();
    }
    /**
     * Returns the type in string form.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}










