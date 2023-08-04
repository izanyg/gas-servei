<?php
/**
 * This class manages fonts
 *
 * @package shopkeeper
 */

?>
<?php
/**
 * Reads theme options and generates fonts enqueue urls
 */
class Shopkeeper_Fonts {

	/**
	 * List of web safe fonts that don't need Google Fonts.
	 *
	 * @var array web fonts.
	 */
	private static $web_safe_fonts = array(
		'--apple-system',
		'Arial',
		'Comic Sans',
		'Courier New',
		'Courier',
		'Garamond',
		'Georgia',
		'Helvetica',
		'Impact',
		'Palatino',
		'Times New Roman',
		'Times',
		'Trebuchet',
		'Verdana'
	);

	/**
	 * List of web suggested fonts.
	 *
	 * @var array suggested fonts.
	 */
	private static $suggested_google_fonts = array(
		'Alata',
		'Blinker',
		'Cabin',
		'Catamaran',
		'DM Sans',
		'DM Serif Display',
		'DM Serif Text',
		'EB Garamond',
		'Exo 2',
		'IBM Plex Sans',
		'IBM Plex Serif',
		'Lato',
		'Lexend Deca',
		'Libre Baskerville',
		'Libre Franklin',
		'Literata',
		'Lora',
		'Merriweather Sans',
		'Merriweather',
		'Montserrat',
		'Muli',
		'Neuton',
		'Noto Sans',
		'Noto Serif',
		'Nunito Sans',
		'Nunito',
		'Open Sans',
		'Public Sans',
		'PT Sans Caption',
		'PT Sans',
		'PT Serif Caption',
		'PT Serif',
		'Playfair Display',
		'Red Hat Display',
		'Red Hat Text',
		'Quattrocento Sans',
		'Quattrocento',
		'Red Hat Display',
		'Roboto Condensed',
		'Roboto Mono',
		'Roboto Slab',
		'Roboto',
		'Rubik',
		'Source Sans Pro',
		'Source Serif Pro',
		'Titillium Web',
		'Ubuntu',
		'Vollkorn',
		'Work Sans',
	);

	/**
	 * Get the enqueue URL for the fonts selected.
	 *
	 * @return [string] [font link]
	 */
	public static function get_google_font_url( $font ) {

		$web_safe_fonts = array( 'web-safe-sans-serif', 'web-safe-serif' );
		$google_font_family = '';

		// Continue if the font name is empty, or matches one of the web safe fonts
		if ( $font && !in_array( $font, self::$web_safe_fonts ) ) {

			$font_value = $font . ':400,500,600,700,400italic,700italic';

			if ( $font_value && ! in_array( $font_value, $web_safe_fonts ) ) {
				$google_font_family = urlencode( $font_value );
			}

			$display = Shopkeeper_Opt::getOption( 'default_fonts_fontface_display', 'swap' );

			if ( $google_font_family ) {
				$google_fonts_url = '//fonts.googleapis.com/css?display='.$display.'&family=' . $google_font_family;

				return $google_fonts_url;
			}
		}

		return;
	}

	/**
	* Get the font fallback list.
	*
	* @return [array] [font fallback list]
	*/
	private static function get_font_fallbacks( $font ) {

		$sans_serif_list = '-apple-system, BlinkMacSystemFont, Arial, Helvetica, \'Helvetica Neue\', Verdana, sans-serif';
		$serif_list 	 = 'Bookman Old Style, Georgia, Garamond, \'Times New Roman\', Times, serif';
		$mono_list 		 = 'Courier, Lucida Console, Monaco, monospace';

		if ( strpos( $font, ' Mono' ) !== false ) {
			return $mono_list;
		} else if ( strpos( $font, ' Sans' ) !== false ) {
			return $sans_serif_list;
		} else if ( strpos( $font, ' Serif' ) !== false || strpos( $font, ' Slab' ) !== false ) {
			return $serif_list;
		}

		return $sans_serif_list;
	}

	/**
	* Returns the array of suggested google fonts.
	*
	* @return [string] [processed value]
	*/
	public static function get_google_suggested_fonts_list() {

		$list = '<datalist id="shopkeeper-suggested-google-fonts">';
		foreach ( self::$suggested_google_fonts as $font ) {
			$list .= '<option value="' . esc_attr( $font ) . '">';
		}
		$list .= '</datalist>';

		return $list;
	}

	/**
	* Returns the array of suggested web safe fonts.
	*
	* @return [string] [processed value]
	*/
	public static function get_web_safe_suggested_fonts_list() {

		$list = '<datalist id="shopkeeper-suggested-web-fonts">';
		foreach ( self::$web_safe_fonts as $font ) {
			$list .= '<option value="' . esc_attr( $font ) . '">';
		}
		$list .= '</datalist>';

		return $list;
	}

	/**
	* Returns the array of suggested theme fonts.
	*
	* @return [string] [processed value]
	*/
	public static function get_defaults_suggested_fonts_list() {
		$list = '<datalist id="shopkeeper-suggested-default-fonts">
					<option value="NeueEinstellung">
					<option value="Radnika">
				</datalist>';

		return $list;
	}

	/**
	* Get the font used as custom style.
	*
	* @return [string] [processed value]
	*/
	public static function get_font( $font ) {

		$main_font_stack = 	self::get_font_fallbacks( $font );

		if( $font ) {
			return '"' . $font . '", '. $main_font_stack;
		}

		return $main_font_stack;
	}

	/**
	* Get the main font used as custom style.
	*
	* @return [string] [processed value]
	*/
	public static function get_main_font() {

		switch( Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) ) {
			case 'default':
				$font = Shopkeeper_Opt::getOption( 'main_font_default', 'NeueEinstellung' );
				break;
			case 'google':
				$font = Shopkeeper_Opt::getOption( 'main_font_google', 'Roboto' );
				break;
			case 'web-safe':
				$font = Shopkeeper_Opt::getOption( 'main_font_web_safe', 'Arial' );
				break;
			case 'custom':
				$font = Shopkeeper_Opt::getOption( 'main_font_custom', '' );
				break;
			case 'adobe':
				$font = Shopkeeper_Opt::getOption( 'main_font_adobe', '' );
				break;
			default:
				$font = Shopkeeper_Opt::getOption( 'main_font_default', 'NeueEinstellung' );
				break;
		}

		return self::get_font( $font );
	}

	/**
	* Get the secondary font used as custom style.
	*
	* @return [string] [processed value]
	*/
	public static function get_secondary_font() {

		switch( Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) ) {
			case 'default':
				$font = Shopkeeper_Opt::getOption( 'secondary_font_default', 'Radnika' );
				break;
			case 'google':
				$font = Shopkeeper_Opt::getOption( 'secondary_font_google', 'Roboto' );
				break;
			case 'web-safe':
				$font = Shopkeeper_Opt::getOption( 'secondary_font_web_safe', 'Arial' );
				break;
			case 'custom':
				$font = Shopkeeper_Opt::getOption( 'secondary_font_custom', '' );
				break;
			case 'adobe':
				$font = Shopkeeper_Opt::getOption( 'secondary_font_adobe', '' );
				break;
			default:
				$font = Shopkeeper_Opt::getOption( 'secondary_font_default', 'Radnika' );
				break;
		}

		return self::get_font( $font );
	}
}
