<?php
namespace Nexd\Discord;

/**
 * Every class that inherits from this class has to be in their own file with the same name.
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
					// in case if its not included already
					require_once __DIR__ . "/$value.php";

					// set class namespace
					$value = "Nexd\Discord\\".$value;

					// if the property is an array, every element should be instantiated
					if(is_array($this->{$property}))
					{
						foreach($this->{$property} as $propertyindex => $propertyvalue)
						{
							if(isset($propertyvalue) && !is_string($propertyvalue))
								$this->{$property}[$propertyindex] = new $value($propertyvalue);
						}
					} else {
						$this->{$property} = new $value($this->{$property});
					}
				}
			}
		}
    }
}
?>
