<?php
namespace Nexd\Discord;

class DiscordChannelType
{
    /**
     * a text channel within a server
     */
    public const GUILD_TEXT = 0;

    /**
     * a direct message between users
     */
    public const DM = 1;

    /**
     * a voice channel within a server
     */
    public const GUILD_VOICE = 2;

    /**
     * a direct message between multiple users
     */
    public const GROUP_DM = 3;

    /**
     * 	an organizational category that contains up to 50 channels
     */
    public const GUILD_CATEGORY = 4;

    /**
     * a channel that users can follow and crosspost into their own server
     */
    public const GUILD_NEWS = 5;

    /**
     * a channel in which game developers can sell their game on Discord
     */
    public const GUILD_STORE = 6;

    /**
     * 	a temporary sub-channel within a GUILD_NEWS channel
     */
    public const GUILD_NEWS_THREAD = 10;

    /**
     * a temporary sub-channel within a GUILD_TEXT channel
     */
    public const GUILD_PUBLIC_THREAD = 11;

    /**
     * a temporary sub-channel within a GUILD_TEXT channel that is only viewable by those invited and those with the MANAGE_THREADS permission
     */
    public const GUILD_PRIVATE_THREAD = 12;

    /**
     * a voice channel for hosting events with an audience
     */
    public const GUILD_STAGE_VOICE  = 13;
}

class DiscordChannelOverwriteObject extends DiscordObjectParser
{
    /**
     * role or user id
     */
    public string $id;

    /**
     * either 0 (role) or 1 (member)
     */
    public int $type;

    /**
     * permission bit set
     */
    public string $allow;

    /**
     * permission bit set
     */
    public string $deny;
}

class VoiceRegion extends DiscordObjectParser
{
    /**
     * unique ID for the region
     */
    public string $id;

    /**
     * name of the region
     */
    public string $name;

    /**
     * 	true if this is a vip-only server
     */
    public bool $vip;

    /**
     * 	true for a single server that is closest to the current user's client
     */
    public bool $optimal;

    /**
     * whether this is a deprecated voice region (avoid switching to these)
     */
    public bool $deprecated;

    /**
     * 	whether this is a custom voice region (used for events/etc)
     */
    public bool $custom;
}

class VideoQualityModes
{
    /**
     * Discord chooses the quality for optimal performance
     */
    public const AUTO = 1;

    /**
     * 720p
     */
    public const FULL = 2;
}

class ThreadMetadata extends DiscordObjectParser
{
    /**
     * whether the thread is archived
     */
    public bool $archived;

    /**
     * duration in minutes to automatically archive the thread after recent activity, can be set to: 60, 1440, 4320, 10080
     */
    public int $auto_archive_duration;

    /**
     * 	timestamp when the thread's archive status was last changed, used for calculating recent activity
     */
    public string $archive_timestamp;

    /**
     * whether the thread is locked; when a thread is locked, only users with MANAGE_THREADS can unarchive it
     */
    public bool $locked;
}

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

class ModifyDiscordChannel
{
    /**
     * 1-100 character channel name
     */
    public string $name;

    /**
     * 	the type of channel; only conversion between text and news is supported and only in guilds with the "NEWS" feature
     */
    public int $type;

    /**
     * the position of the channel in the left-hand listing
     */
    public ?int $position;

    /**
     * 0-1024 character channel topic
     */
    public ?string $topic;

    /**
     * whether the channel is nsfw
     */
    public ?bool $nsfw;

    /**
     * amount of seconds a user has to wait before sending another message (0-21600); bots, as well as users with the permission manage_messages or manage_channel, are unaffected
     */
    public ?int $rate_limit_per_user;

    /**
     * the bitrate (in bits) of the voice channel; 8000 to 96000 (128000 for VIP servers)
     */
    public ?int $bitrate;

    /**
     * the user limit of the voice channel; 0 refers to no limit, 1 to 99 refers to a user limit
     */
    public ?int $user_limit;

    /**
     * channel or category-specific permissions
     */
    public ?array $permission_overwrites;

    /**
     * 	id of the new parent category for a channel
     */
    public ?string $parent_id;

    /**
     * channel voice region id, automatic when set to null
     */
    public ?string $rtc_region;

    /**
     * the camera video quality mode of the voice channel
     */
    public ?int $video_quality_mode;

    /**
     * the default duration for newly created threads in the channel, in minutes, to automatically archive the thread after recent activity
     */
    public ?int $default_auto_archive_duration;
}

class DiscordChannel extends DiscordObjectParser
{
    public function __construct(array $properties = array())
    {
        parent::__construct($properties);
        $this->thread_metadata = new ThreadMetadata($this->thread_metadata);
        $this->member = new ThreadMember($this->member);
    }

    /**
     * the id of this channel
     */
    public string $id;

    /**
     * the type of channel
     */
    public int $type;

    /**
     * 	the id of the guild (may be missing for some channel objects received over gateway guild dispatches)
     */
    public string $guild_id;

    /**
     * sorting position of the channel
     */
    public ?int $position = null;

    /**
     * 	explicit permission overwrites for members and roles
     */
    public array $permission_overwrites;

    /**
     * the name of the channel (1-100 characters)
     */
    public string $name;

    /**
     * the channel topic (0-1024 characters)
     */
    public ?string $topic = null;

    /**
     * whether the channel is nsfw
     */
    public ?bool $nsfw = null;

    /**
     * the id of the last message sent in this channel (may not point to an existing or valid message)
     */
    public ?string $last_message_id;

    /**
     * 	the bitrate (in bits) of the voice channel
     */
    public ?int $bitrate = null;

    /**
     * 	the user limit of the voice channel
     */
    public ?int $user_limit = null;

    /**
     * 	amount of seconds a user has to wait before sending another message (0-21600); bots, as well as users with the permission manage_messages or manage_channel, are unaffected
     */
    public ?int $rate_limit_per_user = null;

    /**
     * the recipients of the DM
     */
    public ?array $recipients = null;

    /**
     * icon hash
     */
    public ?string $icon = null;

    /**
     * id of the creator of the group DM or thread
     */
    public ?string $owner_id = null;

    /**
     * application id of the group DM creator if it is bot-created
     */
    public ?string $application_id = null;

    /**
     * for guild channels: id of the parent category for a channel (each parent category can contain up to 50 channels), for threads: id of the text channel this thread was created
     */
    public ?string $parent_id = null;

    /**
     * when the last pinned message was pinned. This may be null in events such as GUILD_CREATE when a message is not pinned.
     */
    public ?string $last_pin_timestamp = null;

    /**
     * 	voice region id for the voice channel, automatic when set to null
     */
    public ?string $rtc_region = null;

    /**
     * the camera video quality mode of the voice channel, 1 when not present
     */
    public ?int $video_quality_mode = null;

    /**
     * 	an approximate count of messages in a thread, stops counting at 50
     */
    public ?int $message_count = null;

    /**
     * 	an approximate count of users in a thread, stops counting at 50
     */
    public ?int $member_count = null;

    /**
     * thread-specific fields not needed by other channels.
     */
    public $thread_metadata = null;

    /**
     * 	thread member object for the current user, if they have joined the thread, only included on certain API endpoints.
     */
    public $member = null;

    /**
     * default duration for newly created threads, in minutes, to automatically archive the thread after recent activity, can be set to: 60, 1440, 4320, 10080
     */
    public ?int $default_auto_archive_duration = null;

    /**
     * computed permissions for the invoking user in the channel, including overwrites, only included when part of the resolved data received on a slash command interaction
     */
    public ?string $permissions = null;
}
?>