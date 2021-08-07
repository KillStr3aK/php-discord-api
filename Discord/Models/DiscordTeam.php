<?php
namespace Nexd\Discord;

class DiscordTeam extends DiscordObjectParser
{
    private const InitializeProperties =
	[	/*Property Name */			/* to */
		"members"	            => "DiscordTeamMember[]"
	];

	public function __construct(array $properties = array())
	{
		parent::__construct($properties, self::InitializeProperties);
	}

	/**
	 * 	the unique id of the team
	 */
	public string $id;

	/**
	 * a hash of the image of the team's icon
	 */
    public ?string $icon;

	/**
	 * 	the members of the team
	 */
    public $members;

	/**
	 * the name of the team
	 */
	public string $name;

	/**
	 * 	the user id of the current team owner
	 */
	public string $owner_user_id;
}
?>