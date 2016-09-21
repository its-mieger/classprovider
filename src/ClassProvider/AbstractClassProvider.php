<?php

	namespace ClassProvider;

	/**
	 * Abstract provider for classes
	 * @package ClassProvider
	 */
	abstract class AbstractClassProvider
	{

		use IndependentStaticFieldsTrait;

		protected static $includes = [];

		/**
		 * Registers a new class
		 * @param string $name The name
		 * @param string $class The class
		 */
		public static function register($name, $class) {

			$map = static::_getStatic('map', []);

			$map[$name] = $class;

			static::_setStatic('map', $map);
		}

		/**
		 * Gets the class for specified name
		 * @param string $name The name
		 * @return string|null The class or null if name not registered
		 */
		public static function get($name) {
			static::init();


			$map = static::_getStatic('map', []);


			if (empty($map[$name]))
				return null;

			return $map[$name];
		}

		/**
		 * Gets all registered classes
		 * @return array The classes. Names as keys.
		 */
		public static function getAll() {
			static::init();

			return static::_getStatic('map', []);
		}

		/**
		 * Adds an include
		 * @param string|string[] $file The glob expression(s) for files to include
		 */
		public static function addInclude($file) {

			$includes = static::_getStatic('includes', []);

			if (!is_array($file)) {
				$includes[] = $file;
			}
			else {
				$includes = array_merge(static::$includes, $file);
			}

			static::_setStatic('includes', $includes);
		}

		/**
		 * Initializes the provider if not already done. All include files are loaded.
		 */
		protected static function init() {
			if (!static::_getStatic('isInit', false)) {

				$includes = static::_getStatic('includes', []);

				foreach ($includes as $currInclude) {
					static::loadIncludes($currInclude);
				}

				static::_setStatic('isInit', true);
			}
		}


		/**
		 * Loads the specified include
		 * @param string $include The include glob expression
		 */
		protected static function loadIncludes($include) {
			$files = glob($include);
			if ($files) {
				foreach ($files as $curr) {
					require_once $curr;
				}
			}
		}

	}