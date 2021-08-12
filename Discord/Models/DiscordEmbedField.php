<?php

namespace Nexd\Discord;

class DiscordEmbedField extends DiscordObjectParser
{
    /**
     * name of the field.
     */
    public ?string $name = null;

    /**
     * value of the field.
     */
    public ?string $value = null;

    /**
     * 	whether or not this field should display inline.
     */
    public ?bool $inline = null;
}
