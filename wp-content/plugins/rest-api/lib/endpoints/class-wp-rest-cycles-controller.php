<?php

/**
 * Access Cycles
 */
class WP_REST_Cycles_Controller extends WP_REST_Controller {

	public function __construct() {
		$this->namespace = 'wp/v2';
		$this->rest_base = 'cycles';
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {

		register_rest_route( $this->namespace, '/' . $this->rest_base, array(
			array(
				'methods'         => WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_items' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'            => $this->get_collection_params(),
			),
			array(
				'methods'         => WP_REST_Server::CREATABLE,
				'callback'        => array( $this, 'create_item' ),
				'permission_callback' => array( $this, 'create_item_permissions_check' ),
				'args'            => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', array(
			array(
				'methods'         => WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_item' ),
				'permission_callback' => array( $this, 'get_item_permissions_check' ),
				'args'            => array(
					'context'          => $this->get_context_param( array( 'default' => 'view' ) ),
				),
			),
			array(
				'methods'         => WP_REST_Server::EDITABLE,
				'callback'        => array( $this, 'update_item' ),
				'permission_callback' => array( $this, 'update_item_permissions_check' ),
				'args'            => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
			),
			array(
				'methods' => WP_REST_Server::DELETABLE,
				'callback' => array( $this, 'delete_item' ),
				'permission_callback' => array( $this, 'delete_item_permissions_check' ),
				'args' => array(
					'force'    => array(
						'default'     => false,
						'description' => __( 'Required to be true, as resource does not support trashing.' ),
					),
					'reassign' => array(),
				),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );

		register_rest_route( $this->namespace, '/' . $this->rest_base . '/me', array(
			'methods'         => WP_REST_Server::READABLE,
			'callback'        => array( $this, 'get_current_item' ),
			'args'            => array(
				'context'          => array(),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		));                
	}

	/**
	 * Permissions check for getting all Cycles.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function get_items_permissions_check( $request ) {
		// Check if roles is specified in GET request and if user can list cycles
		if ( ! empty( $request['roles'] ) && ! current_user_can( 'list_users' ) ) {
			return new WP_Error( 'rest_user_cannot_view', __( 'Sorry, you cannot filter by role.' ), array( 'status' => rest_authorization_required_code() ) );
		}

		return true;
	}

	/**
	 * Get all Cycles
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_items( $request ) {

		$prepared_args = array();
		$prepared_args['exclude'] = $request['exclude'];
		$prepared_args['include'] = $request['include'];
		$prepared_args['order'] = $request['order'];
		$prepared_args['number'] = $request['per_page'];
        
		if ( ! empty( $request['offset'] ) ) {
			$prepared_args['offset'] = $request['offset'];
		} else {
			$prepared_args['offset'] = ( $request['page'] - 1 ) * $prepared_args['number'];
		}
        
		$orderby_possibles = array(
			'id'              => 'ID',
			'name'            => 'name',
		);
                 
		$prepared_args['orderby'] = $orderby_possibles[ $request['orderby'] ];
		$prepared_args['search'] = $request['search'];
		
		if ( ! current_user_can( 'list_users' ) ) {
			$prepared_args['has_published_posts'] = true;
		}

		if ( '' !== $prepared_args['search'] ) {
			$prepared_args['search'] = '*' . $prepared_args['search'] . '*';
		}		

		/**
		 * Filter arguments, before passing to WP_User_Query, when querying users via the REST API.
		 *
		 * @see https://developer.wordpress.org/reference/classes/wp_user_query/
		 *
		 * @param array           $prepared_args Array of arguments for WP_User_Query.
		 * @param WP_REST_Request $request       The current request.
		 */
         
		$prepared_args = apply_filters( 'rest_cycles_query', $prepared_args, $request );

		$results = p2h_get_all_cycle($prepared_args);
        
		foreach ( $results as $cycle ) {
			$data = $this->prepare_item_for_response( $cycle, $request );
			$cycles[] = $this->prepare_response_for_collection( $data );
		}

		$response = rest_ensure_response( $cycles );

		// Store pagation values for headers then unset for count query.
		$per_page = (int) $prepared_args['number'];
		$page = ceil( ( ( (int) $prepared_args['offset'] ) / $per_page ) + 1 );

		$prepared_args['fields'] = 'id';

		$total_cycles = p2h_get_cycle_count();
        		
		$response->header( 'X-WP-Total', (int) $total_cycles );
		$max_pages = ceil( $total_cycles / $per_page );
		$response->header( 'X-WP-TotalPages', (int) $max_pages );

		$base = add_query_arg( $request->get_query_params(), rest_url( sprintf( '/%s/%s', $this->namespace, $this->rest_base ) ) );
		if ( $page > 1 ) {
			$prev_page = $page - 1;
			if ( $prev_page > $max_pages ) {
				$prev_page = $max_pages;
			}
			$prev_link = add_query_arg( 'page', $prev_page, $base );
			$response->link_header( 'prev', $prev_link );
		}
		if ( $max_pages > $page ) {
			$next_page = $page + 1;
			$next_link = add_query_arg( 'page', $next_page, $base );
			$response->link_header( 'next', $next_link );
		}

		return $response;
	}

	/**
	 * Check if a given request has access to read a user
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function get_item_permissions_check( $request ) {

		$id = (int) $request['id'];
		$cycle = p2h_get_cycle( $id );
		
		if ( empty( $id ) || empty( $cycle->id ) ) {
			return new WP_Error( 'rest_user_invalid_id', __( 'Invalid resource id.' ), array( 'status' => 404 ) );
		}

		if ( 'edit' === $request['context'] && ! current_user_can( 'list_users' ) ) {
			return new WP_Error( 'rest_user_cannot_view', __( 'Sorry, you cannot view this resource with edit context.' ), array( 'status' => rest_authorization_required_code() ) );
		} else if ( ! count_user_posts( $id, $types ) && ! current_user_can( 'edit_user', $id ) && ! current_user_can( 'list_users' ) ) {
			return new WP_Error( 'rest_user_cannot_view', __( 'Sorry, you cannot view this resource.' ), array( 'status' => rest_authorization_required_code() ) );
		}

		return true;
	}

	/**
	 * Get a single user
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( $request ) {
		$id = (int) $request['id'];
		$cycle = p2h_get_cycle( $id );

		if ( empty( $id ) || empty( $cycle->id) ) {
			return new WP_Error( 'rest_user_invalid_id', __( 'Invalid resource id.' ), array( 'status' => 404 ) );
		}

		$cycle = $this->prepare_item_for_response( $cycle, $request );
        
		$response = rest_ensure_response( $cycle );

		return $response;
	}
   
	/**
	 * Get the current user
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_current_item( $request ) {
		$current_user_id = get_current_user_id();
		if ( empty( $current_user_id ) ) {
			return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
		}

		$cycle = wp_get_current_user();
		$response = $this->prepare_item_for_response( $cycle, $request );
		$response = rest_ensure_response( $response );
		$response->header( 'Location', rest_url( sprintf( '/%s/%s/%d', $this->namespace, $this->rest_base, $current_user_id ) ) );
		$response->set_status( 302 );

		return $response;
	}

	/**
	 * Check if a given request has access create users
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return boolean
	 */
	public function create_item_permissions_check( $request ) {

		if ( ! current_user_can( 'create_users' ) ) {
			return new WP_Error( 'rest_cannot_create_cycle', __( 'Sorry, you are not allowed to create resource.' ), array( 'status' => rest_authorization_required_code() ) );
		}

		return true;
	}

	/**
	 * Create a single user
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function create_item( $request ) {
		if ( ! empty( $request['id'] ) ) {
			return new WP_Error( 'rest_cycle_exists', __( 'Cannot create existing resource.' ), array( 'status' => 400 ) );
		}		
        
		$cycle = $this->prepare_item_for_database( $request );

		$id = p2h_insert_cycle( $cycle );
        
		if ( is_wp_error( $id ) ) {
			return $id;
		}

		$cycle = p2h_get_cycle( $id );        		

		$this->update_additional_fields_for_object( $cycle, $request );

		/**
		 * Fires after a user is created or updated via the REST API.
		 *
		 * @param WP_User         $cycle      Data used to create the user.
		 * @param WP_REST_Request $request   Request object.
		 * @param boolean         $creating  True when creating user, false when updating user.
		 */
		do_action( 'rest_insert_cycle', $cycle, $request, true );

		$request->set_param( 'context', 'edit' );
		$response = $this->prepare_item_for_response( $cycle, $request );
		$response = rest_ensure_response( $response );
		$response->set_status( 201 );
		$response->header( 'Location', rest_url( sprintf( '/%s/%s/%d', $this->namespace, $this->rest_base, $id ) ) );

		return $response;
	}

	/**
	 * Check if a given request has access update a user
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return boolean
	 */
	public function update_item_permissions_check( $request ) {

		$id = (int) $request['id'];

		if ( ! current_user_can( 'edit_user', $id ) ) {
			return new WP_Error( 'rest_cannot_edit', __( 'Sorry, you are not allowed to edit resource.' ), array( 'status' => rest_authorization_required_code() ) );
		}

		if ( ! empty( $request['roles'] ) && ! current_user_can( 'edit_users' ) ) {
			return new WP_Error( 'rest_cannot_edit_roles', __( 'Sorry, you are not allowed to edit roles of this resource.' ), array( 'status' => rest_authorization_required_code() ) );
		}

		return true;
	}

	/**
	 * Update a single user
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$id = (int) $request['id'];

		$cycle = p2h_get_cycle( $id );
        
		if ( ! $cycle ) {
			return new WP_Error( 'rest_cycle_invalid_id', __( 'Invalid resource id.' ), array( 'status' => 400 ) );
		}

		$cycle = $this->prepare_item_for_database( $request );

		// Ensure we're operating on the same user we already checked
		$cycle['id'] = $id;

		$id = p2h_insert_cycle( $cycle );
        
		if ( is_wp_error( $id ) ) {
			return $id;
		}

		$cycle = p2h_get_cycle( $id );		

		$this->update_additional_fields_for_object( $cycle, $request );

		/* This action is documented in lib/endpoints/class-wp-rest-users-controller.php */
		do_action( 'rest_insert_cycle', $cycle, $request, false );

		$request->set_param( 'context', 'edit' );
		$response = $this->prepare_item_for_response( $cycle, $request );
		$response = rest_ensure_response( $response );
		return $response;
	}

	/**
	 * Check if a given request has access delete a user
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return boolean
	 */
	public function delete_item_permissions_check( $request ) {

		$id = (int) $request['id'];

		if ( ! current_user_can( 'delete_user', $id ) ) {
			return new WP_Error( 'rest_user_cannot_delete', __( 'Sorry, you are not allowed to delete this resource.' ), array( 'status' => rest_authorization_required_code() ) );
		}

		return true;
	}

	/**
	 * Delete a single user
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function delete_item( $request ) {
		$id = (int) $request['id'];
		$reassign = isset( $request['reassign'] ) ? absint( $request['reassign'] ) : null;
		$force = isset( $request['force'] ) ? (bool) $request['force'] : false;

		// We don't support trashing for this type, error out
		if ( ! $force ) {
			return new WP_Error( 'rest_trash_not_supported', __( 'Users do not support trashing.' ), array( 'status' => 501 ) );
		}

		$cycle = get_userdata( $id );
		if ( ! $cycle ) {
			return new WP_Error( 'rest_user_invalid_id', __( 'Invalid resource id.' ), array( 'status' => 400 ) );
		}

		if ( ! empty( $reassign ) ) {
			if ( $reassign === $id || ! get_userdata( $reassign ) ) {
				return new WP_Error( 'rest_user_invalid_reassign', __( 'Invalid resource id for reassignment.' ), array( 'status' => 400 ) );
			}
		}

		$request->set_param( 'context', 'edit' );
		$response = $this->prepare_item_for_response( $cycle, $request );

		/** Include admin user functions to get access to wp_delete_user() */
		require_once ABSPATH . 'wp-admin/includes/user.php';

		$result = wp_delete_user( $id, $reassign );

		if ( ! $result ) {
			return new WP_Error( 'rest_cannot_delete', __( 'The resource cannot be deleted.' ), array( 'status' => 500 ) );
		}

		/**
		 * Fires after a user is deleted via the REST API.
		 *
		 * @param WP_User          $cycle     The user data.
		 * @param WP_REST_Response $response The response returned from the API.
		 * @param WP_REST_Request  $request  The request sent to the API.
		 */
		do_action( 'rest_delete_user', $cycle, $response, $request );

		return $response;
	}

	/**
	 * Prepare a single user output for response
	 *
	 * @param object $cycle User object.
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response $response Response data.
	 */
	public function prepare_item_for_response( $cycle, $request ) {		

        $data = array(
			'id'                 => $cycle->id,
			'name'           =>  $cycle->name,
			'description'               => $cycle->description,
			'image'         => $cycle->image,
			'status'           => $cycle->status					
		);
        
		$schema = $this->get_item_schema();

		$context = ! empty( $request['context'] ) ? $request['context'] : 'embed';
		$data = $this->add_additional_fields_to_object( $data, $request );
		$data = $this->filter_response_by_context( $data, $context );

		// Wrap the data in a response object
		$response = rest_ensure_response( $data );

		/**
		 * Filter user data returned from the REST API.
		 *
		 * @param WP_REST_Response $response  The response object.
		 * @param object           $cycle      User object used to create response.
		 * @param WP_REST_Request  $request   Request object.
		 */
		return apply_filters( 'rest_prepare_cycles', $response, $cycle, $request );
	}

	/**
	 * Prepare links for the request.
	 *
	 * @param WP_Post $cycle User object.
	 * @return array Links for the given user.
	 */
	protected function prepare_links( $cycle ) {
		$links = array(
			'self' => array(
				'href' => rest_url( sprintf( '/%s/%s/%d', $this->namespace, $this->rest_base, $cycle->ID ) ),
			),
			'collection' => array(
				'href' => rest_url( sprintf( '/%s/%s', $this->namespace, $this->rest_base ) ),
			),
		);

		return $links;
	}

	/**
	 * Prepare a single user for create or update
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return object $prepared_cycle User object.
	 */
	protected function prepare_item_for_database( $request ) {
		$prepared_cycle = [];

		// required arguments.
		if ( isset( $request['name'] ) ) {
			$prepared_cycle['name'] = $request['name'];
		}
		if ( isset( $request['description'] ) ) {
			$prepared_cycle['description'] = $request['description'];
		}
		if ( isset( $request['image'] ) ) {
			$prepared_cycle['image'] = $request['image'];
		}
		
		if ( isset( $request['status'] ) ) {
			$prepared_cycle['status'] = $request['status'];
		}
		
		/**
		 * Filter user data before inserting user via the REST API.
		 *
		 * @param object          $prepared_cycle User object.
		 * @param WP_REST_Request $request       Request object.
		 */
		return apply_filters( 'rest_pre_insert_cycles', $prepared_cycle, $request );
	}

	/**
	 * Determine if the current user is allowed to make the desired roles change.
	 *
	 * @param integer $cycle_id
	 * @param array   $roles
	 * @return WP_Error|boolean
	 */
	protected function check_role_update( $cycle_id, $roles ) {
		global $wp_roles;

		foreach ( $roles as $role ) {

			if ( ! isset( $wp_roles->role_objects[ $role ] ) ) {
				return new WP_Error( 'rest_user_invalid_role', sprintf( __( 'The role %s does not exist.' ), $role ), array( 'status' => 400 ) );
			}

			$potential_role = $wp_roles->role_objects[ $role ];
			// Don't let anyone with 'edit_users' (admins) edit their own role to something without it.
			// Multisite super admins can freely edit their blog roles -- they possess all caps.
			if ( ! ( is_multisite() && current_user_can( 'manage_sites' ) ) && get_current_user_id() === $cycle_id && ! $potential_role->has_cap( 'edit_users' ) ) {
				return new WP_Error( 'rest_user_invalid_role', __( 'You cannot give resource that role.' ), array( 'status' => rest_authorization_required_code() ) );
			}

			// The new role must be editable by the logged-in user.

			/** Include admin functions to get access to get_editable_roles() */
			require_once ABSPATH . 'wp-admin/includes/admin.php';

			$editable_roles = get_editable_roles();
			if ( empty( $editable_roles[ $role ] ) ) {
				return new WP_Error( 'rest_user_invalid_role', __( 'You cannot give resource that role.' ), array( 'status' => 403 ) );
			}
		}

		return true;

	}

	/**
	 * Get the Cycle's schema, conforming to JSON Schema
	 *
	 * @return array
	 */
	public function get_item_schema() {
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'cycles',
			'type'       => 'object',
			'properties' => array(
				'id'          => array(
					'description' => __( 'Unique identifier for the resource.' ),
					'type'        => 'integer',
					'context'     => array( 'embed', 'view', 'edit' ),
					'readonly'    => true,
				),
				'name'    => array(
					'description' => __( 'Name for the resource.' ),
					'type'        => 'string',
					'context'     => array( 'embed', 'view', 'edit' ),
					'required'    => true,					
				),
				'description'        => array(
					'description' => __( 'Desription for the resource.' ),
					'type'        => 'string',
					'context'     => array( 'embed', 'view', 'edit' ),					
				),
				'image'  => array(
					'description' => __( 'Image path for the resource.' ),
					'type'        => 'string',
					'context'     => array( 'embed', 'view', 'edit' ),					
				),
                'status'  => array(
					'description' => __( 'Status for the resource.' ),
					'type'        => 'integer',
					'context'     => array( 'embed', 'view', 'edit' ),					
				),				
			),
		);		

		return $this->add_additional_fields_schema( $schema );
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		$query_params = parent::get_collection_params();

		$query_params['context']['default'] = 'view';

		$query_params['exclude'] = array(
			'description'        => __( 'Ensure result set excludes specific ids.' ),
			'type'               => 'array',
			'default'            => array(),
			'sanitize_callback'  => 'wp_parse_id_list',
		);
		$query_params['include'] = array(
			'description'        => __( 'Limit result set to specific ids.' ),
			'type'               => 'array',
			'default'            => array(),
			'sanitize_callback'  => 'wp_parse_id_list',
		);
		$query_params['offset'] = array(
			'description'        => __( 'Offset the result set by a specific number of items.' ),
			'type'               => 'integer',
			'sanitize_callback'  => 'absint',
			'validate_callback'  => 'rest_validate_request_arg',
		);
		$query_params['order'] = array(
			'default'            => 'asc',
			'description'        => __( 'Order sort attribute ascending or descending.' ),
			'enum'               => array( 'asc', 'desc' ),
			'sanitize_callback'  => 'sanitize_key',
			'type'               => 'string',
			'validate_callback'  => 'rest_validate_request_arg',
		);
		$query_params['orderby'] = array(
			'default'            => 'name',
			'description'        => __( 'Sort collection by object attribute.' ),
			'enum'               => array(
				'id',
				'include',
				'name',
				'registered_date',
			),
			'sanitize_callback'  => 'sanitize_key',
			'type'               => 'string',
			'validate_callback'  => 'rest_validate_request_arg',
		);
		$query_params['slug']    = array(
			'description'        => __( 'Limit result set to resources with a specific slug.' ),
			'type'               => 'string',
			'validate_callback'  => 'rest_validate_request_arg',
		);
		$query_params['roles']   = array(
			'description'        => __( 'Limit result set to resources matching at least one specific role provided. Accepts csv list or single role.' ),
			'type'               => 'array',
			'sanitize_callback'  => 'wp_parse_slug_list',
		);
		return $query_params;
	}
}
