<?php

namespace Nexd\Discord;

class DiscordGuildWelcomeScreenChannel extends DiscordObjectParser
{
    /**
     * the channel's id.
     */
    public string $channel_id;

    /**
     * 	the description shown for the channel.
     */
    public string $description;

    /**
     * the emoji id, if the emoji is custom.
     */
    public ?string $emoij_id;

    /**
     * the emoji name if custom, the unicode character if standard, or null if no emoji is set.
     */
    public ?string $emoji_name;
}
