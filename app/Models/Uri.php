<?php

namespace App\Models;

use App\Models\ContentType;

class Uri
{
    /** @var string $agent */
    protected string $agent = "";
    /** @var string $uri */
    protected string $uri = "";

    /** @var array $headers */
    protected array $headers = [];

    /** @var array $getValues */
    protected array $getValues = [];
    /** @var string|null $bearerToken */
    protected string|null $bearerToken = null;
    /** @var int $timeout Timeout in seconds */
    protected int $timeout = 30;
    /** @var int $maxRedirections */
    protected int $maxRedirections = 4;
    /** @var ContentType $contentType */
    protected ContentType $contentType;

    /**
     *  Sets the default content type for the request.
     */
    public function __construct()
    {
        $this->setContentType(ContentType::get()->TEXT_HTML());
    }

    /**
     * Sets the content type for the request.
     *
     * @param ContentType $contentType
     * @return self
     */
    public function setContentType(ContentType $contentType): self
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function get(): array|\stdClass
    {
        // Initiates curl with the uri and the get values.
        $curl = curl_init($this->uri . "?" . http_build_query($this->getValues, "", "&"));
        // Checks if there is a bearer key to be set.
        if (!empty($this->bearerToken)) {
            // Adds the bearer key to the headers.
            $this->addHeader("Authorization", "Bearer " . $this->bearerToken);
        }

        // Checks if the content type isn't empty. (Should NEVER be empty.)
        if (!empty($this->contentType)) {
            // Adds the content type to the headers.
            $this->addHeader("Content-Type", $this->contentType->getType());
        }

        // Checks if there is a specific agent the requests needs to use.
        if (!empty($this->agent)) {
            // Adds the agent to the headers.
            $this->addHeader("User-Agent", $this->agent);
        }

        // Disables that the request, when finished is going to print out the results.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // Adds all headers to the request.
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        // Enables headers.
        curl_setopt($curl, CURLOPT_HEADER, true);

        // Checks if there is a specific agent the requests needs to use.
        if (!empty($this->agent)) {
            // Sets the agent for the request.
            curl_setopt($curl, CURLOPT_USERAGENT, $this->agent);
        }
        // Sets the maximum timeout time for the request.
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return json_decode(explode("\r\n\r\n", $response)[1]);
    }

    /**
     * Add a header to the request.
     *
     * @param string $header
     * @param string $value
     * @return self
     */
    public function addHeader(string $header, string $value): self
    {
        $this->headers[] = $header . ": " . $value;
        return $this;
    }

    /**
     * Sets the user agent the request needs to use.
     *
     * @param string $agent
     * @return self
     */
    public function setUserAgent(string $agent): self
    {
        $this->agent = $agent;
        return $this;
    }

    /**
     * Sets the URI to which the request needs to be sent.
     *
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Add headers to the request. (Only overrides existing headers if they are in the $headers.)
     *
     * @param array $headers
     * @return self
     */
    public function addHeaders(array $headers): self
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }
        return $this;
    }

    /**
     * Resets the headers to an empty array.
     *
     * @return self
     */
    public function resetHeaders(): self
    {
        $this->headers = [];
        return $this;
    }

    /**
     * Clears all the get values to an empty array.
     *
     * @return self
     */
    public function clearGetValues(): self
    {
        $this->getValues = [];
        return $this;
    }

    /**
     * Sets the bearer token to be used in the request.
     * Overrides the Authorization header if set!
     *
     * @param string $token
     * @return self
     */
    public function setBearerToken(string $token): self
    {
        $this->bearerToken = $token;
        return $this;
    }

    /**
     * Add a get value.
     * If key already exists, this overrides it.
     *
     * @param string $key
     * @param string $value
     * @return self
     */
    public function addGetValue(string $key, string $value): self
    {
        $this->getValues[$key] = $value;
        return $this;
    }

    /**
     * Sets the timeout in seconds.
     *
     * @param int $timeout
     * @return self
     */
    public function setTimeout(int $timeout = 30): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Sets the maximum redirections allowed.
     *
     * @param int $maxRedirections
     * @return self
     */
    public function setMaxRedirections(int $maxRedirections = 4): self
    {
        $this->maxRedirections = $maxRedirections;
        return $this;
    }
}
