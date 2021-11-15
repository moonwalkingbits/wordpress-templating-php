<?php

namespace Moonwalking_Bits\Templating\Engine;

use Moonwalking_Bits\Templating\Template_Not_Found_Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Moonwalking_Bits\Templating\Engine\Php
 */
class Php_Test extends TestCase {
	private array $template_directories = array(
		__DIR__ . '/fixtures/templates/'
	);
	private Php $engine;

	/**
	 * @before
	 */
	public function set_up(): void {
		$this->engine = new Php( $this->template_directories );
	}

	/**
	 * @test
	 */
	public function should_throw_exception_if_template_not_found(): void {
		$this->expectException( Template_Not_Found_Exception::class );

		$this->engine->render( 'not-found' );
	}

	/**
	 * @test
	 */
	public function should_locate_template_by_name(): void {
		$this->assertEquals( 'title', $this->engine->render( 'index' ) );
	}

	/**
	 * @test
	 */
	public function should_locate_template_by_name_and_extension(): void {
		$this->assertEquals( 'title', $this->engine->render( 'index.php' ) );
	}

	/**
	 * @test
	 */
	public function should_locate_template_in_sub_directory(): void {
		$this->assertEquals( 'title', $this->engine->render( 'sub/index' ) );
	}

	/**
	 * @test
	 */
	public function should_accept_template_directories(): void {
		$engine = new Php();
		$engine->add_template_directories( $this->template_directories );

		$this->assertEquals( 'title', $engine->render( 'index.php' ) );
	}

	/**
	 * @test
	 */
	public function should_render_template_in_given_context(): void {
		$context = array(
			'title' => 'context'
		);

		$this->assertEquals( 'context', $this->engine->render( 'index.php', $context ) );
	}
}
