<?php 

// Create fields
// Show columns
// Save/Update fields
// Update the Walker nav

function store_lite_menu_fields_list() {
	//note that menu-item- gets prepended to field names
	//i.e.: field-01 becomes menu-item-field-01
	//i.e.: icon-url becomes menu-item-icon-url
	return array(
		'mm-megamenu' => 'Activate MegaMenu',
		'mm-column-divider' => 'Column Divider',
		'mm-divider' => 'Inline Divider',
		'mm-featured-image' => 'Featured Image',
		'mm-description' => 'Description',
	);
}

// Setup fields
function store_lite_mega_menu_fields( $id, $item, $depth, $args ) {

	$fields = store_lite_menu_fields_list();

	foreach ( $fields as $_key => $label ) :
		$key   = sprintf( 'menu-item-%s', $_key );
		$id    = sprintf( 'edit-%s-%s', $key, $item->ID );
		$name  = sprintf( '%s[%s]', $key, $item->ID );
		$value = get_post_meta( $item->ID, $key, true );
		$class = sprintf( 'field-%s', $_key );

		$css = '';
		if( $depth > 0 && $_key == 'mm-megamenu' ){
			$css = esc_attr('display: none');
		}
		if( ( $depth == 0 || $depth > 1 ) && $_key == 'mm-column-divider' ){
			$css = esc_attr('display: none');
		}
		if( $depth < 1 && $_key == 'mm-featured-image' ){
			$css = esc_attr('display: none');
		}
		if( $depth < 1 && $_key == 'mm-divider' ){
			$css = esc_attr('display: none');
		}
		if( $depth < 1 && $_key == 'mm-description' ){
			$css = esc_attr('display: none');
		}
		?>
		<p style="<?php echo esc_attr( $css ); ?>" class="description description-wide <?php echo esc_attr( $class ) ?>">
			<label for="<?php echo esc_attr( $id ); ?>"><input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo ( $value == 1 ) ? 'checked="checked"' : ''; ?> /><?php echo esc_html( $label ); ?></label>
		</p>
		<?php
	endforeach;

}

add_action( 'wp_nav_menu_item_custom_fields', 'store_lite_mega_menu_fields', 10, 4 );

// Create Columns
function store_lite_megamenu_columns( $columns ) {

	$fields = store_lite_menu_fields_list();

	$columns = array_merge( $columns, $fields );

	return $columns;
}

add_filter( 'manage_nav-menus_columns', 'store_lite_megamenu_columns', 99 );

// Save fields
function store_lite_megamenu_save( $menu_id, $menu_item_db_id, $menu_item_args ) {
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

	$fields = store_lite_menu_fields_list();

	foreach ( $fields as $_key => $label ) {
		$key = sprintf( 'menu-item-%s', $_key );

		// Sanitize.
		if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
			// Do some checks here...
			$value = $_POST[ $key ][ $menu_item_db_id ];
		} else {
			$value = null;
		}

		// Update.
		if ( ! is_null( $value ) ) {
			update_post_meta( $menu_item_db_id, $key, $value );
		} else {
			delete_post_meta( $menu_item_db_id, $key );
		}
	}
}

add_action( 'wp_update_nav_menu_item', 'store_lite_megamenu_save', 10, 3 );

function store_lite_megamenu_filter_walker( $walker ) {
    $walker = 'MegaMenu_Walker_Edit';
    if ( ! class_exists( $walker ) ) {
        require get_template_directory(). '/inc/mega-menu/walker-nav-menu-edit.php';
    }

    return $walker;
}

add_filter( 'wp_edit_nav_menu_walker', 'store_lite_megamenu_filter_walker', 99 );