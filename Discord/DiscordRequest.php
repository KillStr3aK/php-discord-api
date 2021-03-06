<?php

namespace Nexd\Discord;

require_once __DIR__.'/Exceptions/DiscordInvalidResponseException.php';
use Nexd\Discord\Exceptions\DiscordInvalidResponseException;

class HTTPResponseCode
{
    /**
     * The request completed successfully.
     */
    public const OK = 200;

    /**
     * The entity was created successfully.
     */
    public const CREATED = 201;

    /**
     * The request completed successfully but returned no content.
     */
    public const NOCONTENT = 204;

    /**
     * The entity was not modified (no action was taken).
     */
    public const NOTMODIFIED = 304;

    /**
     * The request was improperly formatted, or the server couldn't understand it.
     */
    public const BADREQUEST = 400;

    /**
     * The Authorization header was missing or invalid.
     */
    public const UNAUTHORIZED = 401;

    /**
     * The Authorization token you passed did not have permission to the resource.
     */
    public const FORBIDDEN = 403;

    /**
     * The resource at the location specified doesn't exist.
     */
    public const NOTFOUND = 404;

    /**
     * 	The HTTP method used is not valid for the location specified.
     */
    public const METHODNOTALLOWED = 405;

    /**
     * You are being rate limited, see Rate Limits at https://canary.discord.com/developers/docs/topics/rate-limits.
     */
    public const TOOMANYREQUEST = 429;

    /**
     * There was not a gateway available to process your request. Wait a bit and retry.
     */
    public const GATEWAYUNAVAILABLE = 502;
}

class DiscordRequest
{
    public const HTTPRequestMethod_GET = 'GET';
    public const HTTPRequestMethod_POST = 'POST';
    public const HTTPRequestMethod_PUT = 'PUT';
    public const HTTPRequestMethod_DELETE = 'DELETE';
    public const HTTPRequestMethod_PATCH = 'PATCH';

    private const API_URL = 'https://discord.com/api/';
    private array $headers = [];
    private array $postfields = [];
    private string $jsonBody = '';

    public string $route;
    public string $method;

    public function __construct(string $route, string $method, string $content_type = 'application/json')
    {
        $this->route = $route;
        $this->method = $method;

        $this->SetHeader("Content-Type: $content_type");
    }

    public function SetHeader(string $header): void
    {
        array_push($this->headers, $header);
    }

    public function SetBot(DiscordBot $bot): void
    {
        $this->SetHeader("Authorization: Bot $bot->token");
    }

    public function SetJsonBody(mixed $any): void
    {
        $this->jsonBody = json_encode($any, JSON_THROW_ON_ERROR);
        $this->SetHeader('Content-Length: '.strlen($this->jsonBody));
    }

    public function AddPostField(mixed $any): void
    {
        array_push($this->postfields, $any);
    }

    public function SetPostFields(array $fields): void
    {
        $this->postfields = $fields;
    }

    /**
     * Send request to Discord API.
     *
     * @throws DiscordInvalidResponseException
     */
    public function Send(): mixed
    {
        $sent = false;

        while (!$sent) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, DiscordRequest::API_URL.$this->route);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            if (isset($this->jsonBody) && !empty($this->jsonBody)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $this->jsonBody);
            } elseif (isset($this->postfields) && !empty($this->postfields)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->postfields));
            }

            $response = curl_exec($curl);
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($code == HTTPResponseCode::TOOMANYREQUEST) {
                $response = json_decode($response, false, 512, JSON_THROW_ON_ERROR);
                usleep($response->retry_after * 1000);
            } else {
                $sent = true;
                if ($code < HTTPResponseCode::OK || $code >= HTTPResponseCode::BADREQUEST) {
                    throw new DiscordInvalidResponseException("Discord returned invalid response!\nCode: $code\nBody: $response");
                }

                $results = json_decode($response, true);

                return $results;
            }
        }
    }
}
