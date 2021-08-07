<?php
namespace Nexd\Discord;

class MembershipState
{
	public const INVITED = 1;

	public const ACCEPTED = 2;
}

class DiscordTeamMember extends DiscordObjectParser
{
    private const InitializeProperties =
	[	/*Property Name */			/* to */
		"user"	            => "DiscordUser"
	];

	public function __construct(array $properties = array())
	{
		parent::__construct($properties, self::InitializeProperties);
	}

	/**
	 * 	the user's membership state on the team
	 */
	public int $membership_state;

	/**
	 * will always be ["*"]
	 */
	public array $permissions;

	/**
	 * the id of the parent team of which they are a member
	 */
	public string $team_id;

	/**
	 * partical DiscordUser object, avatar, discriminator, id, and username of the user
	 */
	public $user;
}
?>