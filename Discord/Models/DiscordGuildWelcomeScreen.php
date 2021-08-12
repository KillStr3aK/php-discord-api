<?php

namespace Nexd\Discord;

class DiscordGuildWelcomeScreen extends DiscordObjectParser
{
    /**
     * the server description shown in the welcome screen.
     */
    public ?string $description;

    /**
     * the channels shown in the welcome screen, up to 5.
     */
    public array $welcome_channels;
}
