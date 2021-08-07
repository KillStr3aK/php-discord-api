<?php
namespace Nexd\Discord;

class ModifyDiscordGuildMember
{
	/**
	 * value to set users nickname to
	 */
	public ?string $nick = null;

	/**
	 * array of role ids the member is assigned
	 */
	public array $roles = [];

	/**
	 * whether the user is muted in voice channels. Will throw a 400 if the user is not in a voice channel
	 */
	public bool $mute = false;

	/**
	 * whether the user is deafened in voice channels. Will throw a 400 if the user is not in a voice channel
	 */
	public bool $deaf = false;

	/**
	 * 	id of channel to move user to (if they are connected to voice)
	 */
	public ?string $channel_id = null;

	/**
	 * value to set users nickname to
	 */
	public function SetNickname(string $nickname) : self
	{
		$this->nick = $nickname;
		return $this;
	}

	/**
	 * array of role ids the member is assigned
	 */
	public function SetRoles(array $roles) : self
	{
		$this->roles = $roles;
		return $this;
	}

	/**
	 * whether the user is muted in voice channels. Will throw a 400 if the user is not in a voice channel
	 */
	public function SetMute(bool $state) : self
	{
		$this->mute = $state;
		return $this;
	}

	/**
	 * whether the user is deafened in voice channels. Will throw a 400 if the user is not in a voice channel
	 */
	public function SetDeafen(bool $state) : self
	{
		$this->deaf = $state;
		return $this;
	}

	/**
	 * 	id of channel to move user to (if they are connected to voice)
	 */
	public function MoveToChannel(string $channelid) : self
	{
		$this->channel_id = $channelid;
		return $this;
	}
}

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
	public ?string $premium_since;

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