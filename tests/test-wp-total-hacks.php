<?php

class WPTotalHacksTest extends WP_UnitTestCase
{
	private $post_ids;

	function setup()
	{
		parent::setUp();
		$this->post_ids = $this->factory->post->create_many( 25 );

		$this->attachment_id = $this->factory->attachment->create_object( 'image.jpg', 0, array(
			'post_mime_type' => 'image/jpeg',
			'post_type' => 'attachment'
		) );
	}

	/**
	 * Tests for remove_xmlrpc
	 * @test
	 */
	function remove_xmlrpc()
	{
		// go to page and force fire wp_head()
		ob_start();
		$this->go_to( get_permalink( $this->post_ids[0] ) );
		do_action( 'get_header' );
		wp_head();
		$header = ob_get_clean();

		$this->assertSame( 1, preg_match( '#<link rel="EditURI"#', $header ) );
		$this->assertSame( 1, preg_match( '#<link rel="wlwmanifest"#', $header ) );

		update_option( 'wfb_remove_xmlrpc', 1 );
		// go to page and force fire wp_head()
		ob_start();
		$this->go_to( get_permalink( $this->post_ids[0] ) );
		do_action( 'get_header' );
		wp_head();
		$header = ob_get_clean();
		$this->assertSame( 0, preg_match( '#<link rel="EditURI"#', $header ) );
		$this->assertSame( 0, preg_match( '#<link rel="wlwmanifest"#', $header ) );
	}

	/**
	 * Tests for site icon
	 * @test
	 */
	function site_icon()
	{
		update_option( 'wfb_favicon', 'path/to/favicon.png' );
		update_option( 'wfb_apple_icon', 'path/to/apple_icon.png' );
		// go to page and force fire wp_head()
		ob_start();
		$this->go_to( get_permalink( $this->post_ids[0] ) );
		do_action( 'get_header' );
		wp_head();
		$header = ob_get_clean();

		$this->assertSame( 1, preg_match( '#<link rel="Shortcut Icon" type="image/x-icon" href="//path/to/favicon.png" />#', $header ) );
		$this->assertSame( 1, preg_match( '#<link rel="apple-touch-icon" href="//path/to/apple_icon.png" />#', $header ) );

		if ( has_site_icon() ) {
			update_option( 'site_icon', $this->attachment_id );
			// go to page and force fire wp_head()
			ob_start();
			$this->go_to( get_permalink( $this->post_ids[0] ) );
			do_action( 'get_header' );
			wp_head();
			$header = ob_get_clean();

			$this->assertSame( 0, preg_match( '#<link rel="Shortcut Icon" type="image/x-icon" href="//path/to/favicon.png" />#', $header ) );
			$this->assertSame( 0, preg_match( '#<link rel="apple-touch-icon" href="//path/to/apple_icon.png" />#', $header ) );
		}
	}
}
