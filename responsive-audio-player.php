<?php
/*
	Plugin Name: Responsive Audio Player
	Description: WordPress plugin for http://osvaldas.info/audio-player-responsive-and-touch-friendly. 
	             Usage: [resp-player width="50%" mp3="http://example.com/file.mp3"]
	Version: 0.1
	Author: Rodolfo Buaiz 
	Author URI: http://www.rodbuaiz.com
*/
add_shortcode( 'resp-player', 'b5f_responsive_audio_shortcode' );
add_action( 'wp_enqueue_scripts', 'b5f_enqueue_shortcode_scripts' );
add_action( 'wp_default_scripts', 'ds_enqueue_jquery_in_footer' );

function b5f_responsive_audio_shortcode($atts) 
{
	$width = isset( $atts['width'] ) ? " style='width:{$atts['width']}'" : '';
	$mp3 = isset( $atts['mp3'] ) ? '<source src="' . $atts['mp3'] .'" />' : '';
	$ogg = isset( $atts['ogg'] ) ? "<source src='{$atts['ogg']}' />" : '';
	$wav = isset( $atts['wav'] ) ? "<source src='{$atts['wav']}' />" : ''; 
	$html = <<<HTML
	<div $width>
		<audio controls preload="auto">
			$mp3
			$ogg
			$wav
			This text displays if the audio tag isn't supported.
		</audio>
	</div>
HTML;
	return $html;
}

function b5f_enqueue_shortcode_scripts()
{
	if( b5f_post_has_shortcode( 'resp-player' ) )
	{
		wp_enqueue_style( 'resp-player-css', plugins_url( 'audio-player.css', __FILE__) );
		wp_enqueue_script( 'resp-player-js', plugins_url( 'audio-player.js', __FILE__), array('jquery'), false, true );
	}
}


/**
 * Description: Prints jQuery in footer on front-end.
 * Author:      Dominik Schilling
 * Author URI:  http://wpgrafie.de/
 */
function ds_enqueue_jquery_in_footer( &$scripts ) {
	 
	if ( ! is_admin() )
		$scripts->add_data( 'jquery', 'group', 1 );
}


function b5f_post_has_shortcode($shortcode = '') 
{  
    $post_to_check = get_post(get_the_ID());  
    $found = false;  
    if (!$shortcode) 
        return $found;  
    
    if ( stripos($post_to_check->post_content, '[' . $shortcode) !== false ) 
        $found = true;  
    
    return $found;  
}