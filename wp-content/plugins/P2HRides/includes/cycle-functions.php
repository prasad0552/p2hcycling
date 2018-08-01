<?php

/**
 * Get all cycle
 *
 * @param $args array
 *
 * @return array
 */
function p2h_get_all_cycle( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'cycle-all';
    $items     = wp_cache_get( $cache_key, 'wep2h' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'p2h_cycles ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'wep2h' );
    }

    return $items;
}

/**
 * Fetch all cycle from database
 *
 * @return array
 */
function p2h_get_cycle_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'p2h_cycles' );
}

/**
 * Fetch a single cycle from database
 *
 * @param int   $id
 *
 * @return array
 */
function p2h_get_cycle( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'p2h_cycles WHERE id = %d', $id ) );
}

/**
 * Insert a new cycle
 *
 * @param array $args
 */
function p2h_insert_cycle( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'name' => '',
        'description' => '',
        'image' => '',
        'status' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'p2h_cycles';

    // some basic validation
    if ( empty( $args['name'] ) ) {
        return new WP_Error( 'no-name', __( 'No Name provided.', 'wep2h' ) );
    }
    if ( empty( $args['description'] ) ) {
        return new WP_Error( 'no-description', __( 'No Description provided.', 'wep2h' ) );
    }
    if ( empty( $args['image'] ) ) {
        return new WP_Error( 'no-image', __( 'No Image Path provided.', 'wep2h' ) );
    }
    if ( empty( $args['status'] ) ) {
        return new WP_Error( 'no-status', __( 'No Status provided.', 'wep2h' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

//        $args['date'] = current_time( 'mysql' );

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}
