<?php

namespace OpenGraph;

/**
 * OpenGraph class tests
 * @group OpenGraph
 */
class Tests_OpenGraph extends \Fuel\Core\TestCase {
	/**
	 * @test
	 */
	public function test_forge() {
		$o1 = OpenGraph::forge();
		$this->assertTrue($o1 instanceof PropertyHolder);

		$o2 = OpenGraph::forge('test');
		$this->assertTrue($o2 instanceof PropertyHolder);

		$this->assertNotEquals($o1, $o2);
	}

	/**
	 * @test
	 */
	public function test_forge2() {
		$o1 = OpenGraph::forge('test2');
		$o2 = OpenGraph::forge('test2');
		$this->assertEquals($o1, $o2);
	}

	/**
	 * @test
	 */
	public function test_instance() {
		// already exists
		$o1 = OpenGraph::instance();
		$this->assertTrue($o1 instanceof PropertyHolder);

		// new one
		$o2 = OpenGraph::instance('test3');
		$this->assertTrue($o2 instanceof PropertyHolder);

		$this->assertNotEquals($o1, $o2);
	}

	/**
	 * @test
	 */
	public function test_forge_instance() {
		// test default name
		$o1 = OpenGraph::forge();
		$o2 = OpenGraph::instance();
		$this->assertEquals($o1, $o2);

		// new one
		$o1 = OpenGraph::forge('test4');
		$o2 = OpenGraph::instance('test4');
		$this->assertEquals($o1, $o2);
	}
}