<?php
namespace Nexd\Discord;

class DiscordRole extends DiscordObjectParser
{
    private const InitializeProperties =
	[	/*Property Name */			/* to */
		"tags"	            => "DiscordRoleTags"
	];

	public function __construct(array $properties = array())
	{
		parent::__construct($properties, self::InitializeProperties);
	}

    /**
     * role id
     */
    public ?string $id = null;

    /**
     * role name
     */
    public ?string $name = null;

    /**
     * integer representation of hexadecimal color code
     */
    public ?int $color = null;

    /**
     * if this role is pinned in the user listing
     */
    public ?bool $hoist = null;

    /**
     * position of this role
     */
    public ?int $position = null;

    /**
     * permission bit set
     */
    public ?string $permissions = null;

    /**
     * whether this role is managed by an integration
     */
    public ?bool $managed = null;

    /**
     * 	whether this role is mentionable
     */
    public ?bool $mentionable = null;

    /**
     * the tags this role has
     */
    public $tags = null;
}
?>