<?php
namespace Nexd\Discord;

class DiscordGuildMember extends DiscordObjectParser
{
	private const InitializeProperties =
	[	/*Property Name */			/* to */
		"user"				=> "DiscordUser"
	];

	public function __construct(array $properties = array())
	{
		parent::__construct($properties, self::InitializeProperties);
	}

	/**
	 * the user this guild member represents
	 */
	public $user;

	/**
	 * 	this users guild nickname
	 */
	public ?string $nick;

	/**
	 * array of role object ids
	 */
	public array $roles;

	/**
	 * when the user joined the guild
	 */
	public string $joined_at;

	/**
	 * when the user started boosting the guild
	 */
	public string $premium_since;

	/**
	 * whether the user is deafened in voice channels
	 */
	public bool $deaf;

	/**
	 * 	whether the user is muted in voice channels
	 */
	public bool $mute;

	/**
	 * whether the user has not yet passed the guild's Membership Screening requirements
	 */
	public bool $pending;

	/**
	 * total permissions of the member in the channel, including overwrites, returned when in the interaction object
	 */
	public string $permissions;
}
?>