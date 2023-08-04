<?php
/**
 * Options Heading control class
 *
 * @package SK_Customize_Heading_Control
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	include ABSPATH . WPINC . '/class-wp-customize-control.php';
}

/**
 * Class SK_Customize_Heading_Control
 */
class SK_Customize_Heading_Control extends WP_Customize_Control {

	public $type = 'sk_heading';

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the $id as the setting ID.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the control's content.
	 */
	public function render_content()
	{
		?>
        <div class="customize-sk_heading-control">
			<label>
	            <?php echo esc_html( $this->label ); ?>
	        </label>
		</div>
		<?php
	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {}
}
