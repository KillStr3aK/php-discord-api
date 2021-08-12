<?php

namespace Nexd\Discord;

class IntegrationApplication extends DiscordObjectParser
{
    private const InitializeProperties =
    [/*Property Name */			/* to */
        'bot'	            => 'DiscordUser',
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    /**
     * the id of the app.
     */
    public string $id;

    /**
     * 	the name of the app.
     */
    public string $name;

    /**
     * the icon hash of the app.
     */
    public ?string $icon;

    /**
     * the description of the app.
     */
    public string $description;

    /**
     * 	the summary of the app.
     */
    public string $summary;

    /**
     * the bot associated with this application.
     */
    public $bot;
}
