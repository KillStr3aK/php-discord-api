<?php

namespace Nexd\Discord;

class DiscordChannelOverwriteObject extends DiscordObjectParser
{
    /**
     * role or user id.
     */
    public string $id;

    /**
     * either 0 (role) or 1 (member).
     */
    public int $type;

    /**
     * permission bit set.
     */
    public string $allow;

    /**
     * permission bit set.
     */
    public string $deny;
}
