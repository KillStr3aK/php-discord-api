<?php

namespace Nexd\Discord;

class DiscordEmbedAuthor extends DiscordObjectParser
{
    /**
     * name of author.
     */
    public ?string $name;

    /**
     * url of author.
     */
    public ?string $url;

    /**
     * url of author icon (only supports http(s) and attachments).
     */
    public ?string $icon_url;

    /**
     * a proxied url of author icon.
     */
    public ?string $proxy_icon_url;

    public function __construct(array $properties = [])
    {
        parent::__construct($properties);
    }
}
