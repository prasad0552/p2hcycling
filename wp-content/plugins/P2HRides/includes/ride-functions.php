<?php

/**
 * Get all ride
 *
 * @param $args array
 *
 * @return array
 */
function p2h_get_all_ride( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'ride_id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'ride-all';
    $items     = wp_cache_get( $cache_key, 'wep2h' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'user_rides ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'wep2h' );
    }

    return $items;
}

/**
 * Fetch all ride from database
 *
 * @return array
 */
function p2h_get_ride_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'user_rides' );
}

/**
 * Fetch a single ride from database
 *
 * @param int   $id
 *
 * @return array
 */
function p2h_get_ride( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'user_rides WHERE ride_id = %d', $id ) );
}

/**
 * Insert a new ride
 *
 * @param array $args
 */
function p2h_insert_ride( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'ride_id'         => null,
        'user_id' => '',
        'date' => '',
        'start_time' => '',
        'end_time' => '',
        'fare' => '',
        'is_submitted' => '',
        'rating' => '',
    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'user_rides';

    // some basic validation
    if ( empty( $args['user_id'] ) ) {
        return new WP_Error( 'no-user_id', __( 'No User provided.', 'wep2h' ) );
    }
    if ( empty( $args['date'] ) ) {
        return new WP_Error( 'no-date', __( 'No Date provided.', 'wep2h' ) );
    }
    if ( empty( $args['start_time'] ) ) {
        return new WP_Error( 'no-start_time', __( 'No Start Time provided.', 'wep2h' ) );
    }
    if ( empty( $args['end_time'] ) ) {
        return new WP_Error( 'no-end_time', __( 'No End Time provided.', 'wep2h' ) );
    }
    if ( empty( $args['fare'] ) ) {
        return new WP_Error( 'no-fare', __( 'No Fare provided.', 'wep2h' ) );
    }
    if ( empty( $args['is_submitted'] ) ) {
        return new WP_Error( 'no-is_submitted', __( 'No Submitted provided.', 'wep2h' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['ride_id'];
    unset( $args['ride_id'] );

    if ( ! $row_id ) {

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'ride_id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}