/**
 * Remove the course slug from published post permalinks. Only affect our custom post type, though.
 */
function gp_remove_cpt_slug( $post_link, $post, $leavename ) {
 
    if ( ('course' == $post->post_type || 'portfolio' == $post->post_type ) && 'publish' == $post->post_status ) {
    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link ); // change 'course' and 'portfolio' to your slug.
        return $post_link;
    }
    return $post_link;
}
add_filter( 'post_type_link', 'gp_remove_cpt_slug', 10, 3 );
function gp_add_cpt_post_names_to_main_query( $query ) {
	// Bail if this is not the main query.
	if ( ! $query->is_main_query() ) {
		return;
	}
	// Bail if this query doesn't match our very specific rewrite rule.
	if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
		return;
	}
	// Bail if we're not querying based on the post name.
	if ( empty( $query->query['name'] ) ) {
		return;
	}
	// Add CPT to the list of post types WP will include when it queries based on the post name.
	$query->set( 'post_type', array( 'post', 'page', 'course', 'portfolio' ) ); // change 'course' and 'portfolio' to your slug
}
add_action( 'pre_get_posts', 'gp_add_cpt_post_names_to_main_query' );
