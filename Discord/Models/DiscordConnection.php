<?php

namespace Nexd\Discord;

class DiscordConnection extends DiscordObjectParser
{
    /**
     * id of the connection account.
     */
    public string $id;

    /**
     * the username of the connection account.
     */
    public string $name;

    /**
     * the service of the connection (twitch, youtube).
     */
    public string $type;

    /**
     * 	whether the connection is revoked.
     */
    public bool $revoked;

    /**
     * an array of partial server integrations.
     */
    public array $integrations;

    /**
     * whether the connection is verified.
     */
    public bool $verified;

    /**
     * whether friend sync is enabled for this connection.
     */
    public bool $friend_sync;

    /**
     * whether activities related to this connection will be shown in presence updates.
     */
    public bool $show_activity;

    /**
     * visibility of this connection.
     */
    public int $visibility;
}
