<?php
namespace Nexd\Discord;

class ThreadMember extends DiscordObjectParser
{
    /**
     * the id of the thread
     */
    public string $id;

    /**
     * the id of the user
     */
    public string $user_id;

    /**
     * the time the current user last joined the thread
     */
    public string $join_timestamp;

    /**
     * any user-thread settings, currently only used for notifications
     */
    public int $flags;
}
?>