<?php

namespace OpenGraph;

/**
 * PropertyHolder class tests.
 * All tests are made through the OpenGraph static methods if possible.
 * @group OpenGraph
 */
class Tests_PropertyHolder extends \Fuel\Core\TestCase {
	private static function is_prop_present($name) {
		return strpos(OpenGraph::get(), 'og:'.$name) !== false;
	}

	/**
	 * @test
	 */
	public function test_header() {
		$this->assertEquals('xmlns:og="http://ogp.me/ns#"', OpenGraph::header());
	}

	/**
	 * @test
	 */
	public function test_title() {
		OpenGraph::title('Test title');
		$this->assertTrue(self::is_prop_present('title'));
	}

	/**
	 * @test
	 */
	public function test_type() {
		OpenGraph::type('Test title');
		$this->assertTrue(self::is_prop_present('type'));
	}

	/**
	 * @test
	 */
	public function test_url() {
		OpenGraph::url('http://example.com');
		$this->assertTrue(self::is_prop_present('url'));
	}

	/**
	 * @test
	 */
	public function test_image() {
		OpenGraph::image('http://example.com/image.png');
		$this->assertTrue(self::is_prop_present('image'));
	}

	/**
	 * @test
	 * @expectedException OutOfRangeException
	 */
	public function test_invalid_add() {
		OpenGraph::add('dummy_prop', 'Dummy data');
	}

	/**
	 * @test
	 * @expectedException OutOfRangeException
	 */
	public function test_invalid_add_struct() {
		OpenGraph::add_struct('dummy_prop', 'dummy_struct', 'Dummy data');
	}

	/**
	 * @test
	 * @expectedException OutOfRangeException
	 */
	public function test_invalid_add_struct2() {
		OpenGraph::add_struct('image', 'dummy_struct', 'Dummy data');
	}

	/**
	 * @test
	 * @expectedException OutOfRangeException
	 */
	public function test_invalid_add_struct3() {
		OpenGraph::add_struct('dummy_prop', 'url', 'Dummy data');
	}

	/**
	 * @test
	 */
	public function test_add() {
		OpenGraph::add('email', 'email@example.com');
		$this->assertTrue(self::is_prop_present('email'));
	}

	/**
	 * @test
	 */
	public function test_add_struct() {
		OpenGraph::add_struct('image', 'url', 'http://example.com/image.png');
		$this->assertTrue(self::is_prop_present('image:url'));

		OpenGraph::add_struct('video', 'type', 'mp4');
		$this->assertTrue(self::is_prop_present('video:type'));
	}
}