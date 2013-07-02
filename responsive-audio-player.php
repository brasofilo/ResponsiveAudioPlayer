<?php
/**
 * Plugin Name: Responsive Audio Player
 * Description: WordPress shortcode for http://osvaldas.info/audio-player-responsive-and-touc iendly. 
 * Usage [resp-player width="50%" mp3="http://example.com/file.mp3"]
 * Structured upon Plugin Class Demo, by toscho, https://gist.github.com/3804204.
 * Version: 2013.07.02
 * Author: Rodolfo Buaiz 
 * Author URI: http://www.rodbuaiz.com
 */

add_action(
	'plugins_loaded',
	array ( B5F_Responsive_Audio_Player::get_instance(), 'plugin_setup' )
);
 
class B5F_Responsive_Audio_Player
{
	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 * @type object
	 */
	protected static $instance = NULL;
 
	/**
	 * URL to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_url = '';
 
	/**
	 * Path to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_path = '';
 
	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @since   2012.09.13
	 * @return  object of this class
	 */
	public static function get_instance()
	{
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}
 
	/**
	 * Used for regular plugin work.
	 *
	 * @wp-hook plugins_loaded
	 * @since   2012.09.10
	 * @return  void
	 */
	public function plugin_setup()
	{
 
		$this->plugin_url    = plugins_url( '/', __FILE__ );
		$this->plugin_path   = plugin_dir_path( __FILE__ );
		$this->load_language( 'b5f-rap' );
 
		add_shortcode( 'resp-player', array( $this, 'shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_default_scripts', array( $this, 'enqueue_jquery' ) );
	}
 
	/**
	 * Constructor. Intentionally left empty and public.
	 *
	 * @see plugin_setup()
	 * @since 2012.09.12
	 */
	public function __construct() {}

	function shortcode($atts) 
	{
		$width = isset( $atts['width'] ) ? " style='width:{$atts['width']}'" : '';
		$mp3 = isset( $atts['mp3'] ) ? '<source src="' . $atts['mp3'] .'" />' : '';
		$ogg = isset( $atts['ogg'] ) ? "<source src='{$atts['ogg']}' />" : '';
		$wav = isset( $atts['wav'] ) ? "<source src='{$atts['wav']}' />" : ''; 
		$text = __( "This text displays if the audio tag isn't supported.", 'b5f-rap' );
		$html = <<<HTML
		<div $width>
			<audio controls preload="auto">
				$mp3
				$ogg
				$wav
				$text
			</audio>
		</div>
HTML;
		return $html;
	}

	function enqueue_scripts()
	{
		if( $this->has_shortcode( 'resp-player' ) )
		{
			wp_enqueue_style( 'resp-player-css', $this->plugin_url . 'audio-player.css' );
			wp_enqueue_script( 'resp-player-js', $this->plugin_url . 'audio-player.js', array('jquery'), false, true );
		}
	}


	/**
	 * Description: Prints jQuery in footer on front-end.
	 * Author:      Dominik Schilling
	 * Author URI:  http://wpgrafie.de/
	 */
	function enqueue_jquery( &$scripts ) {

		if ( ! is_admin() )
			$scripts->add_data( 'jquery', 'group', 1 );
	}


	private function has_shortcode( $shortcode = '' ) 
	{  
		$post_to_check = get_post(get_the_ID());  
		$found = false;  
		if ( !$shortcode ) 
			return $found;  

		if ( stripos( $post_to_check->post_content, '[' . $shortcode) !== false ) 
			$found = true;  

		return $found;  
	}

	/**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files (admin and
	 * front-end for example).
	 *
	 * @wp-hook init
	 * @param   string $domain
	 * @since   2012.09.11
	 * @return  void
	 */
	public function load_language( $domain )
	{
		load_plugin_textdomain(
			$domain,
			FALSE,
			$this->plugin_path . 'languages'
		);
	}
}



