<?php
/*
Plugin Name: Sosoplug
Plugin URI: http://localhost:10003/
Description: temps de lecture 
Author: Brhaiberh 
Version: 1.0
Author URI: http://localhost:10003/
*/

function capitaine_reading_time( $post_id, $post, $update )  {


	if( ! $update ) {
    	return;
	}

	// On ne veut pas executer le code lorsque c'est une révision
	if( wp_is_post_revision( $post_id ) ) {
		return;
	}

	// On évite les sauvegardes automatiques
	if( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) {
		return;
	}

	// Seulement pour les articles
	if( $post->post_type != 'post' ) {
    	return;
	}

	// Tester un seul type de publication
if( $post->post_type != 'post' ) { return; }
	if( ! $update ) { return; }
	if( wp_is_post_revision( $post_id ) ) { return; }
	if( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) { return; }
	if( $post->post_type != 'post' ) { return; }

	// Calculer le temps de lecture
	$word_count = str_word_count( strip_tags( $post->post_content ) );

	// On prend comme base 250 mots par minute
	$minutes = ceil( $word_count / 250 );
	
	// On sauvegarde la meta
	update_post_meta( $post_id, 'reading_time', $minutes );
}
add_action( 'save_post', 'capitaine_reading_time', 10, 3 );

function capitaine_set_category_on_new_post( $post_id, $post, $update )  {

	if( ! $update ) {
    	wp_set_post_terms( $post_id, 12, 'category', true );
	}
}


add_filter('the_content', 'affichage',10);


// fonction affichage 
function affichage($content){
	global $id;
	if (! is_single())
	{
		return $content;
	}
	?>
	
<p> 
    Temps de lecture : 
    <?php echo get_post_meta( $id, 'reading_time', true ); ?> minutes
</p>
<?php
return $content;
}
?>