<?php

namespace Nexd\Discord;

class VoiceRegion extends DiscordObjectParser
{
    /**
     * unique ID for the region.
     */
    public string $id;

    /**
     * name of the region.
     */
    public string $name;

    /**
     * 	true if this is a vip-only server.
     */
    public bool $vip;

    /**
     * 	true for a single server that is closest to the current user's client.
     */
    public bool $optimal;

    /**
     * whether this is a deprecated voice region (avoid switching to these).
     */
    public bool $deprecated;

    /**
     * 	whether this is a custom voice region (used for events/etc).
     */
    public bool $custom;
}
