<?php

	namespace ClassProvider;

	/**
	 * Trait for class independent static fields
	 * @package ClassProvider
	 */
	trait IndependentStaticFieldsTrait {

		protected static $fields = [];

		/**
		 * Gets a static independent field value
		 * @param string $name The field name
		 * @param mixed|null $default The default value, if yet not set
		 * @return mixed|null The field value or the default value
		 */
		protected static function _getStatic($name, $default = null) {
			$cc = get_called_class();

			if (!empty(self::$fields[$cc]) && array_key_exists($name, self::$fields[$cc]))
				return self::$fields[$cc][$name];

			return $default;
		}

		/**
		 * Sets the value for a static independent field.
		 * @param string $name The field name
		 * @param mixed $value The value
		 */
		protected static function _setStatic($name, $value) {
			$cc = get_called_class();

			self::$fields[$cc][$name] = $value;
		}
	}