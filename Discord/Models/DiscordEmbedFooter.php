<?php

namespace Nexd\Discord;

class DiscordEmbedFooter extends DiscordObjectParser
{
    /**
     * footer text.
     */
    public ?string $text = null;

    /**
     * url of footer icon (only supports http(s) and attachments).
     */
    public ?string $icon_url = null;

    /**
     * a proxied url of footer icon.
     */
    public ?string $proxy_icon_url = null;
}
