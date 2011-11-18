<?php

namespace OpenGraph;

/**
 * The purpose of this class is to ease the adding of Open Graph ( http://ogp.me/ )
 * information to a page.
 */
class OpenGraph {
	/**
	 * @var PropertyHolder default instance
	 */
	protected static $_instance;

	/**
	 * @var array contains references to all instantiations of OpenGraph
	 */
	protected static $_instances = array();

	/**
	 * Load the configuration
	 */
	public static function _init() {
		\Config::load('opengraph', true);
	}

	/**
	 * Create a new instance of OpenGraph. If a name is given, you will be able
	 * to retrieve the created instance by name later.
	 * If an instance with this name already exists, a notice is raised and this
	 * instance is returned.
	 * @param string $name Name of the instance
	 * @return PropertyHolder Newly created instance
	 */
	public static function forge($name = 'default') {
		if(isset(static::$_instances[$name])) {
			\Error::notice('OpenGraph with this name exists already, cannot be overwritten.');
			return static::$_instances[$name];
		}
		static::$_instances[$name] = new PropertyHolder();

		if ($name == 'default')
			static::$_instance = static::$_instances[$name];

		return static::$_instances[$name];
	}

	/**
	 * Retrieve a particular instance by name or the default one if none is given.
	 * If no instance exists for the name, a new one is created.
	 * @param string $name Name of the instance
	 * @return PropertyHolder Existing instance or new one if it didn't exists.
	 */
	public static function instance($name = 'default') {
		if(isset(static::$_instances[$name]))
			return static::$_instances[$name];
		else
			return static::forge($name);
	}

	/**
	 * Add the given property to the property list of the default instance,
	 * returns the instance to allow chaining.
	 * An OutOfRangeException is thrown if the property is invalid
	 * @exception OutOfRangeException
	 * @param string $prop The property name
	 * @param mixed $value The value
	 * @return PropertyHolder default instance
	 */
	public static function add($prop, $value) {
		return static::instance()->add($prop, $value);
	}

	/**
	 * Add the given structured property to the property list of the default
	 * instance, returns the instance to allow chaining.
	 * An OutOfRangeException is thrown if the property is invalid
	 * @exception OutOfRangeException
	 * @param string $prop The base property name
	 * @param string $struct The structured property name
	 * @param mixed $value The value
	 * @return PropertyHolder default instance
	 */
	public static function add_struct($prop, $struct, $value) {
		return static::instance()->add_struct($prop, $struct, $value);
	}

	/**
	 * Set the title of the default instance
	 * @param string $title
	 * @return PropertyHolder this
	 */
	public static function title($title) {
		return static::instance()->title($title);
	}

	/**
	 * Set the title of the default instance
	 * @param string $type
	 * @return PropertyHolder this
	 */
	public static function type($type) {
		return static::instance()->type($type);
	}

	/**
	 * Set the url of the default instance
	 * @param string $url
	 * @return PropertyHolder this
	 */
	public static function url($url) {
		return static::instance()->add('url', $url);
	}

	/**
	 * Set the url of the image of the default instance
	 * @param string $image
	 * @return PropertyHolder this
	 */
	public static function image($image) {
		return static::instance()->add('image', $image);
	}


	/**
	 * The Open Graph namespace to add as an attribute of your html tag.
	 * @return type Open Graph namespace
	 */
	public static function header() {
		return static::instance()->header();
	}

	/**
	 * Return the header tags representing the default instance.
	 * Add this to your page head.
	 * @return string
	 */
	public static function get() {
		return static::instance()->get();
	}}