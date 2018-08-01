<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the ride new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit_ride'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'user-rides-new' ) ) {
            die( __( 'Are you cheating?', 'wep2h' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'wep2h' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=user-rides' );
        $field_id = isset( $_POST['ride_id'] ) ? intval( $_POST['ride_id'] ) : 0;

        $user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
        $date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
        $start_time = isset( $_POST['start_time'] ) ? sanitize_text_field( $_POST['start_time'] ) : '';
        $end_time = isset( $_POST['end_time'] ) ? sanitize_text_field( $_POST['end_time'] ) : '';
        $fare = isset( $_POST['fare'] ) ? intval( $_POST['fare'] ) : 0;
        $is_submitted = isset( $_POST['is_submitted'] ) ? sanitize_text_field( $_POST['is_submitted'] ) : '';
        $rating = isset( $_POST['rating'] ) ? intval( $_POST['rating'] ) : 0;

        // some basic validation
        if ( ! $user_id ) {
            $errors[] = __( 'Error: User is required', 'wep2h' );
        }

        if ( ! $date ) {
            $errors[] = __( 'Error: Date is required', 'wep2h' );
        }

        if ( ! $start_time ) {
            $errors[] = __( 'Error: Start Time is required', 'wep2h' );
        }

        if ( ! $end_time ) {
            $errors[] = __( 'Error: End Time is required', 'wep2h' );
        }

        if ( ! $fare ) {
            $errors[] = __( 'Error: Fare is required', 'wep2h' );
        }

        if ( ! $is_submitted ) {
            $errors[] = __( 'Error: Submitted is required', 'wep2h' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'user_id' => $user_id,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'fare' => $fare,
            'is_submitted' => $is_submitted,
            'rating' => $rating,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = p2h_insert_ride( $fields );

        } else {
            $fields['ride_id'] = $field_id;
            $insert_id = p2h_insert_ride( $fields );
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

new Form_Handler();