<?php

namespace Nexd\Discord;

class DiscordInviteMetadata extends DiscordObjectParser
{
    /**
     * number of times this invite has been used.
     */
    public int $uses;

    /**
     * max number of times this invite can be used.
     */
    public int $max_uses;

    /**
     * 	duration (in seconds) after which the invite expires.
     */
    public int $max_age;

    /**
     * 	whether this invite only grants temporary membership.
     */
    public bool $temporary;

    /**
     * when this invite was created.
     */
    public string $created_at;
}
