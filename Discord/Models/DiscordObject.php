<?php
namespace Nexd\Discord;

abstract class DiscordObjectParser
{
    public function __construct(array $properties = array())
    {
        foreach($properties as $key => $value)
        {
            $this->{$key} = $value;
        }
    }
}
?>