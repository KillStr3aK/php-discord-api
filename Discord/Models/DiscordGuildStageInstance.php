<?php
namespace Nexd\Discord;

class DiscordGuildStageInstance extends DiscordObjectParser
{
	/**
	 * The id of this Stage instance
	 */
	public string $id;

	/**
	 * The guild id of the associated Stage channel
	 */
	public string $guild_id;

	/**
	 * 	The id of the associated Stage channel
	 */
	public string $channel_id;

	/**
	 * The topic of the Stage instance (1-120 characters)
	 */
	public string $topic;

	/**
	 * The privacy level of the Stage instance
	 */
	public int $privacy_level;

	/**
	 * 	Whether or not Stage Discovery is disabled
	 */
	public bool $discoverable_disabled;
}
?>