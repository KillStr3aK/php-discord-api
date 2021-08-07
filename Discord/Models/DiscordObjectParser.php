<?php
namespace Nexd\Discord;

/**
 * Parse the Discord API response to the given class, nested objects supported.
 * Every class that inherits from this class has to be in its own file with the same name.
 */
abstract class DiscordObjectParser
{
    public function __construct(array $properties = array(), ?array $objects = null)
    {
        foreach($properties as $key => $value)
        {
            $this->{$key} = $value;
        }

		if(isset($objects))
		{
			/**
			 * Initialize properties to their objects.
			 */
			
			foreach($objects as $property => $value)
			{
				if(isset($this->{$property}))
				{
					// is marked as array
					$isArray = str_ends_with($value, "[]");
					$include = $value;

					if($isArray)
					{
						// remove array mark
						$include = substr($value, 0, strlen($value) - 2);
					}

					// in case if its not included already
					require_once __DIR__ . "/$include.php";

					// set class namespace
					$className = "Nexd\Discord\\".$include;

					// if the property is marked as an array, every element should be instantiated
					if($isArray)
					{
						foreach($this->{$property} as $propertyindex => $propertyvalue)
						{
							if(isset($propertyvalue))
								$this->{$property}[$propertyindex] = new $className($propertyvalue);
						}
					} else {
						$this->{$property} = new $className($this->{$property});
					}
				}
			}
		}
    }
}
?>