<?php

namespace OpenGraph;

/**
 * The purpose of this class is to hold the various properties
 * of an Open Graph.
 */
class PropertyHolder {
	/**
	 * @var string OpenGraph xml namespace
	 */
	private static $_namespace = 'http://ogp.me/ns#';

	/**
	 * @var array OpenGraph properties
	 */
	private static $_properties = array(
		'basic' => array('title', 'type', 'image', 'url'),
		'recommended' => array('description', 'site_name', 'locale'),
		'optional' => array('determiner', 'audio', 'video'),
		'location' => array('latitude', 'longitude', 'street-address', 'locality', 'region', 'postal-code', 'country-name'),
		'contact' => array('email', 'phone_number', 'fax_number'),
	);

	/**
	 * @var array elements with structured properties
	 */
	private static $_structured_properties = array(
		'image' => array('url', 'secure_url', 'type', 'width', 'height'),
		'audio' => array('url', 'secure_url', 'type'),
		'video' => array('url', 'secure_url', 'type', 'width', 'height'),
		'locale' => array('alternates'),
	);

	/**
	 * @var array types from https://developers.facebook.com/docs/opengraph/#types
	 */
	private static $_types = array(
		'activity', 'sport', // Activities
		'bar', 'company', 'cafe', 'hotel', 'restaurant', // Businesses
		'cause', 'sports_league', 'sports_team', // Groups
		'band', 'government', 'non_profit', 'school', 'university', // Organizations
		'actor', 'athlete', 'author', 'director', 'musician', 'politicians', 'public_figure', // People
		'city', 'country', 'landmark', 'state_province', // Places
		'album', 'book', 'drink', 'food', 'game', 'product', 'song', 'movie', 'tv_show', // Products and Entertainment
		'website', 'blog', 'article', // Websites
	);

	/**
	 * @param string $prop property name
	 * @return bool true if the property is a valid one
	 */
	private static function is_property($prop) {
		foreach(static::$_properties as $props)
			if(in_array($prop, $props))
				return true;
		return false;
	}

	/**
	 * @param string $prop property name
	 * @param string $struct structured property name
	 * @return bool true if it is a valid structured property for the property
	 */
	private static function is_structured_property($prop, $struct) {
		return isset(static::$_structured_properties[$prop]) && in_array($struct, static::$_structured_properties[$prop]);
	}

	/**
	 * @var array Our properties with the form name => value
	 */
	private $properties = array();

	/**
	 * Add the given property to the property list, returns the instance to
	 * allow chaining.
	 * @param string $prop The property name
	 * @param mixed $value The value
	 * @return PropertyHolder this
	 */
	private function _add($prop, $value) {
		$this->properties[$prop] = $value;
		return $this;
	}

	/**
	 * Create a new PropertyHolder.
	 * The url OpenGraph property is set to Uri::main()
	 */
	public function __construct() {
		$this->url(\Fuel\Core\Uri::main());
	}

	/**
	 * Add the given property to the property list, returns the instance to
	 * allow chaining.
	 * An OutOfRangeException is thrown if the property is invalid
	 * @exception OutOfRangeException
	 * @param string $prop The property name
	 * @param mixed $value The value
	 * @return PropertyHolder this
	 */
	public function add($prop, $value) {
		if(! static::is_property($prop))
			throw new \OutOfRangeException('invalid property');
		return $this->_add($prop, $value);
	}

	/**
	 * Add the given structured property to the property list, returns the
	 * instance to allow chaining.
	 * An OutOfRangeException is thrown if the property is invalid
	 * @exception OutOfRangeException
	 * @param string $prop The base property name
	 * @param string $struct The structured property name
	 * @param mixed $value The value
	 * @return PropertyHolder this
	 */
	public function add_struct($prop, $struct, $value) {
		if(! static::is_structured_property($prop, $struct))
			throw new \OutOfRangeException('invalid structured property');
		return $this->_add($prop.':'.$struct, $value);
	}

	/**
	 * Set the title of this Open Graph PropertyHolder
	 * @param string $title
	 * @return PropertyHolder this
	 */
	public function title($title) {
		return $this->add('title', $title);
	}

	/**
	 * Set the type of this Open Graph PropertyHolder
	 * @param string $type
	 * @return PropertyHolder this
	 */
	public function type($type) {
		return $this->add('type', $title);
	}

	/**
	 * Set the url of this Open Graph PropertyHolder
	 * @param string $url
	 * @return PropertyHolder this
	 */
	public function url($url) {
		return $this->add('url', $url);
	}

	/**
	 * Set the url of the image of this Open Graph PropertyHolder
	 * @param string $image
	 * @return PropertyHolder this
	 */
	public function image($image) {
		return $this->add('image', $image);
	}

	/**
	 * The Open Graph namespace to add as an attribute of your html tag.
	 * @return type Open Graph namespace
	 */
	public function header() {
		return 'xmlns:og="'.static::$_namespace.'"';
	}

	/**
	 * Return the header tags representing this Open Graph property holder.
	 * Add this to your page head.
	 * @return string
	 */
	public function get() {
		$ret = '';
		foreach($this->properties as $prop => $val) {
			$ret .= '<meta property="og:'.$prop.'" content="'.$val.'">';
		}
		return $ret;
	}
}