<?php

namespace Nexd\Discord;

class ThreadMetadata extends DiscordObjectParser
{
    /**
     * whether the thread is archived.
     */
    public bool $archived;

    /**
     * duration in minutes to automatically archive the thread after recent activity, can be set to: 60, 1440, 4320, 10080.
     */
    public int $auto_archive_duration;

    /**
     * 	timestamp when the thread's archive status was last changed, used for calculating recent activity.
     */
    public string $archive_timestamp;

    /**
     * whether the thread is locked; when a thread is locked, only users with MANAGE_THREADS can unarchive it.
     */
    public bool $locked;
}
