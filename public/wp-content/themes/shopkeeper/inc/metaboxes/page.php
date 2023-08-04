<?php

// CREATE
add_action( 'add_meta_boxes', 'page_options_meta_box_add' );
function page_options_meta_box_add() {
    add_meta_box( 'page_options_meta_box', 'Page Options', 'page_options_meta_box_content', 'page', 'side', 'high' );
}

function page_options_meta_box_content() {
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $page_title_check = isset($values['page_title_meta_box_check']) ? esc_attr($values['page_title_meta_box_check'][0]) : 'on';
    $topbar_selected = isset($values['page_topbar_display']) ? esc_attr( $values['page_topbar_display'][0]) : '';
    $header_check = isset($values['header_meta_box_check']) ? esc_attr($values['header_meta_box_check'][0]) : 'on';
	$footer_check = isset($values['footer_meta_box_check']) ? esc_attr($values['footer_meta_box_check'][0]) : 'on';
	$selected = isset($values['page_header_transparency']) ? esc_attr( $values['page_header_transparency'][0]) : '';
    ?>

    <div class="components-panel__row">
        <div class="components-base-control">
            <div class="components-base-control__field">
                <span class="components-checkbox-control__input-container">
                    <input type="checkbox" id="header_meta_box_check" name="header_meta_box_check" class="components-checkbox-control__input" <?php checked( $header_check, 'on' ); ?> />
                </span>
                <label for="header_meta_box_check"><?php esc_html_e( 'Show Header', 'shopkeeper' ); ?></label>
            </div>
        </div>
    </div>

    <div class="components-panel__row">
        <div class="components-base-control">
            <div class="components-base-control__field">
                <span class="components-checkbox-control__input-container">
                    <input type="checkbox" id="page_title_meta_box_check" name="page_title_meta_box_check" class="components-checkbox-control__input" <?php checked( $page_title_check, 'on' ); ?> />
                </span>
                <label for="page_title_meta_box_check"><?php esc_html_e( 'Show Page Title', 'shopkeeper' ); ?></label>
            </div>
        </div>
    </div>

    <div class="components-panel__row">
        <div class="components-base-control">
            <div class="components-base-control__field">
                <span class="components-checkbox-control__input-container">
                    <input type="checkbox" id="footer_meta_box_check" name="footer_meta_box_check" class="components-checkbox-control__input" <?php checked( $footer_check, 'on' ); ?> />
                </span>
                <label for="footer_meta_box_check"><?php esc_html_e( 'Show Footer', 'shopkeeper' ); ?></label>
            </div>
        </div>
    </div>

    <div class="components-panel__row">
        <div class="components-base-control select-control">
            <label for="page_header_transparency" class="components-base-control__label"><?php esc_html_e( 'Top Bar', 'shopkeeper' ); ?></label>
            <div class="components-base-control__field">
                <select name="page_topbar_display" id="page_topbar_display" style="width:100%">
                    <option value="inherit" <?php selected( $topbar_selected, 'inherit' ); ?>><?php esc_html_e( 'Inherit Customizer Option', 'shopkeeper' ); ?></option>
                    <option value="show" <?php selected( $topbar_selected, 'show' ); ?>><?php esc_html_e( 'Show', 'shopkeeper' ); ?></option>
                    <option value="hide" <?php selected( $topbar_selected, 'hide' ); ?>><?php esc_html_e( 'Hide', 'shopkeeper' ); ?></option>
                </select>
            </div>
        </div>
    </div>

    <div class="components-panel__row">
        <div class="components-base-control select-control">
            <label for="page_header_transparency" class="components-base-control__label"><?php esc_html_e( 'Header Transparency', 'shopkeeper' ); ?></label>
            <div class="components-base-control__field">
                <select name="page_header_transparency" id="page_header_transparency" style="width:100%">
                    <option value="inherit" <?php selected( $selected, 'inherit' ); ?>><?php esc_html_e( 'Inherit Customizer Option', 'shopkeeper' ); ?></option>
                    <option value="transparency_light" <?php selected( $selected, 'transparency_light' ); ?>><?php esc_html_e( 'Light', 'shopkeeper' ); ?></option>
                    <option value="transparency_dark" <?php selected( $selected, 'transparency_dark' ); ?>><?php esc_html_e( 'Dark', 'shopkeeper' ); ?></option>
                    <option value="no_transparency" <?php selected( $selected, 'no_transparency' ); ?>><?php esc_html_e( 'No Transparency', 'shopkeeper' ); ?></option>
                </select>
            </div>
        </div>
    </div>

    <?php

	// We'll use this nonce field later on when saving.
    wp_nonce_field( 'page_options_meta_box', 'page_options_meta_box_nonce' );
}

// SAVE
add_action( 'save_post', 'page_options_meta_box_save' );
function page_options_meta_box_save($post_id) {
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['page_options_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['page_options_meta_box_nonce'], 'page_options_meta_box' ) ) return;

    // if our current user can't edit this post, bail
    if ( !current_user_can( 'edit_post', $post_id ) ) return;

    $header_chk = isset($_POST['header_meta_box_check']) ? 'on' : 'off';
    update_post_meta( $post_id, 'header_meta_box_check', $header_chk );

    $page_title_chk = isset($_POST['page_title_meta_box_check']) ? 'on' : 'off';
    update_post_meta( $post_id, 'page_title_meta_box_check', $page_title_chk );

	$footer_chk = isset($_POST['footer_meta_box_check']) ? 'on' : 'off';
    update_post_meta( $post_id, 'footer_meta_box_check', $footer_chk );

    if( isset( $_POST['page_topbar_display'] ) )
    update_post_meta( $post_id, 'page_topbar_display', esc_attr( $_POST['page_topbar_display'] ) );

	if( isset( $_POST['page_header_transparency'] ) )
    update_post_meta( $post_id, 'page_header_transparency', esc_attr( $_POST['page_header_transparency'] ) );
}
