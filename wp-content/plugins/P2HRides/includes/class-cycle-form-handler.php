<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Cycle_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the cycle new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit_cycle'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'wp_p2h_cycles' ) ) {
            die( __( 'Are you cheating?', 'wep2h' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'wep2h' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=cycles' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $description = isset( $_POST['description'] ) ? wp_kses_post( $_POST['description'] ) : '';
        $image = isset( $_POST['image'] ) ? sanitize_text_field( $_POST['image'] ) : '';
        $status = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : '';

        // some basic validation
        if ( ! $name ) {
            $errors[] = __( 'Error: Name is required', 'wep2h' );
        }

        if ( ! $description ) {
            $errors[] = __( 'Error: Description is required', 'wep2h' );
        }

        if ( ! $image ) {
            $errors[] = __( 'Error: Image Path is required', 'wep2h' );
        }

        if ( ! $status ) {
            $errors[] = __( 'Error: Status is required', 'wep2h' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'status' => $status,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = p2h_insert_cycle( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = p2h_insert_cycle( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Cycle_Form_Handler();