<?php

class Sensei_Settings_Test extends WP_UnitTestCase {
	/**
	 * Set up for tests.
	 */
	public function setUp() {
		Sensei_Test_Events::reset();
		$this->resetSimulateSettingsRequest();

		parent::setUp();
	}

	/**
	 * @covers Sensei_Settings::log_settings_update
	 */
	public function testLogChangedSettings() {
		$settings = Sensei()->settings;
		$new      = $settings->get_settings();

		// Change some settings in General.
		$new['sensei_delete_data_on_uninstall']              = ! $new['sensei_delete_data_on_uninstall'];
		$new['sensei_video_embed_html_sanitization_disable'] = ! $new['sensei_video_embed_html_sanitization_disable'];

		// Change some settings in Courses section.
		$new['course_archive_featured_enable'] = ! $new['course_archive_featured_enable'];
		$new['course_archive_more_link_text']  = $new['course_archive_more_link_text'] . '...';

		// Trigger update with new setting values. Ensure that we are simulating an update from the wp-admin UI.
		$this->simulateSettingsRequest();
		$old = $settings->get_settings();
		$settings->log_settings_update( $old, $new );

		// Ensure events were logged.
		$events = Sensei_Test_Events::get_logged_events();
		$this->assertCount( 2, $events );

		// Ensure General settings were logged.
		$this->assertEquals( 'sensei_settings_update', $events[0]['event_name'] );
		$this->assertEquals( 'default-settings', $events[0]['url_args']['view'] );
		$changed = explode( ',', $events[0]['url_args']['settings'] );
		sort( $changed );
		$this->assertEquals( [ 'sensei_delete_data_on_uninstall', 'sensei_video_embed_html_sanitization_disable' ], $changed );

		// Ensure Course settings were logged.
		$this->assertEquals( 'sensei_settings_update', $events[1]['event_name'] );
		$this->assertEquals( 'course-settings', $events[1]['url_args']['view'] );
		$changed = explode( ',', $events[1]['url_args']['settings'] );
		sort( $changed );
		$this->assertEquals( [ 'course_archive_featured_enable', 'course_archive_more_link_text' ], $changed );
	}

	/**
	 * @covers Sensei_Settings::log_settings_update
	 */
	public function testOnlyLogSettingsOnUserUpdate() {
		$settings = Sensei()->settings;
		$new      = $settings->get_settings();

		// Change a setting.
		$new['sensei_delete_data_on_uninstall'] = ! $new['sensei_delete_data_on_uninstall'];

		// Trigger update with new setting values.
		$old = $settings->get_settings();
		$settings->log_settings_update( $old, $new );

		// Ensure no events were logged.
		$events = Sensei_Test_Events::get_logged_events();
		$this->assertCount( 0, $events );
	}

	/**
	 * Simulate Sensei settings update request.
	 */
	private function simulateSettingsRequest() {
		global $current_screen;

		$this->original_request_method = $_SERVER['REQUEST_METHOD'];
		$this->original_screen         = $current_screen;

		// Simulate the request.
		$_SERVER['REQUEST_METHOD'] = 'POST';
		set_current_screen( 'options' );
	}

	/**
	 * Reset values from simulating Sensei settings update request.
	 */
	private function resetSimulateSettingsRequest() {
		global $current_screen;

		if ( $this->original_request_method ) {
			$_SERVER['REQUEST_METHOD'] = $this->original_request_method;
		} else {
			$_SERVER['REQUEST_METHOD'] = 'GET';
		}

		if ( $this->original_screen ) {
			$current_screen = $this->original_screen;
		} else {
			$current_screen = null;
		}

		$this->original_request_method = null;
		$this->original_screen = null;
	}
}
