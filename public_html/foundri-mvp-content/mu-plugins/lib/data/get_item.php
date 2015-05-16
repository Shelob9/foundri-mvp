<?php
/**
 * Abstract class for classes used to get items from DB via Pods.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
namespace foundri\lib\data;


abstract class get_item {

	/**
	 * The name of the Pod.
	 *
	 * NOTE: Must set in extending class.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $pod_name;

	/**
	 * Item ID
	 *
	 * @since 0.0.1
	 *
	 * @var int
	 */
	public $id;

	/**
	 * Pods object
	 *
	 * @since 0.0.1
	 *
	 * @var \Pods|object
	 */
	public $pods;

	/**
	 * The data to use on front end
	 *
	 * @since 0.0.1
	 *
	 * @var array
	 */
	public $display_data;

	/**
	 * Data as JSON
	 *
	 * Is $this->display_data encoded as JSON
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $json_data;

	/**
	 * Array of fields to use to construct output.
	 *
	 * IMPORTANT: Override in extending class, you must.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var array
	 */
	protected $display_fields = array();

	/**
	 * Is context single item or collection of items?
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var bool
	 */
	protected $single = true;

	/**
	 * Class constructor.
	 *
	 * @since 0.0.1
	 *
	 * @param int $id Item ID
	 * @param bool $markup_fields Optional. Whether to add additional markup fields or not. Default is false, which does not add.
	 */
	public function __construct( $id, $markup_fields = false, $params = false ) {
		if ( $params && is_array( $params ) ) {
			$this->create_properties( $params );

		}
		$this->pre_set();
		$this->set_id( $id );
		$this->set_pods_object();
		if ( $this->single ) {
			$this->set_display_data( $markup_fields );
		} else {
			$this->set_display_data_with_loop();

		}
		$this->set_json_data();

	}

	/**
	 * Set id property
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 *
	 * @param int $id
	 */
	private function set_id( $id ) {
		$this->id = (int) $id;
	}

	/**
	 * Set pods property
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 */
	private function set_pods_object() {

		$this->pods = pods( $this->pod_name );

		$params = array(
			'expires' => MINUTE_IN_SECONDS,
			'cache_mode' => 'cache',
		);

		if ( method_exists( $this, 'where_clause' ) && is_string( $this->where_clause() )) {
			$params[ 'where' ] = $this->where_clause();
		} elseif ( property_exists( $this, 'where_pattern') ) {
			$params[ 'where' ] = sprintf( $this->where_pattern, $this->id );

		}else{
			if ( 0 < $this->id ) {
				if ( 'pod' == $this->pods->api->pod_data[ 'type' ] ) {
					$params[ 'where' ] = sprintf( 't.id = "%d"', $this->id );
				} else {
					$params[ 'where' ] = sprintf( 't.ID = "%d"', $this->id );
				}
			}

		}

		if ( property_exists( $this, 'search_param' ) ) {
			global $wpdb;
			$search = $wpdb->esc_like( $this->search_param );
			$params[ 'search' ] = esc_sql( '%' . $search . '%' );

		}

		if ( property_exists( $this, 'limit' ) ) {
			$params[ 'limit' ] = $this->limit;
		}

		if ( property_exists( $this, 'page' ) ) {
			$params[ 'page' ] = $this->page;
		}

		$this->pods->find( $params );

		if (  $this->single && 0 < $this->id && $this->id != $this->pods->id ) {
			$this->pods->fetch( $this->id );
		}

	}

	/**
	 * Set display_data property
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param bool $markup_fields Optional. Whether to add additional markup fields or not. Default is false, which does not add.
	 */
	protected function set_display_data( $markup_fields, $set_property = true ) {
		$data = array(
			'ID' => $this->pods->id()
		);

		foreach( $this->display_fields as $field => $sub_fields ) {
			$_value = $this->pods->field( $field );
			if ( ! empty( $sub_fields ) ) {
				foreach( $sub_fields as $sub_field ) {
					if ( isset( $_value[ 0 ] ) ) {
						foreach( $_value as $i => $_v ) {
							$data[ $field ][ $i ] = pods_v( $sub_field, $_v );
						}
					}else {
						$data[ $field ] = pods_v( $sub_field, $_value );
					}
				}
			}else{
				$data[ $field ] = $_value;
			}

		}

		if ( FOUNDRI_ASK == $this->pod_name ) {
			$data[ 'link' ] = foundri_link( $this->pods->display( 'permalink' ) );
			$data[ 'link_markup' ] = foundri_link_markup( $this->pods->display( 'permalink' ), $this->pods->display( 'name' ) );
		}else{
			$data[ 'link' ] = foundri_link( $this->pods->id() );
			$data[ 'link_markup' ] = foundri_link_markup( $this->pods->id(), $this->pods->display( 'post_title' ) );
		}

		if ( $set_property ) {
			if ( $markup_fields ) {
				$this->display_data = array_merge( $data, $this->set_markup_fields() );
			} else {
				$this->display_data = $data;
			}
		}else {
			return $data;
		}


	}

	protected function set_display_data_with_loop() {
		$data = array();
		if ( 0 < $this->pods->total() ) {
			while( $this->pods->fetch() ) {
				$data[] = $this->set_display_data( false, false );
			}

		}
		$this->display_data = $data;

	}

	/**
	 * Set json_data property
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 */
	protected function set_json_data() {
		$this->json_data = wp_json_encode( $this->display_data );
	}

	/**
	 * Set markup_fields property
	 *
	 * NOTE: Is an empty array, override in extending class to add additional fields need in template, like form HTML.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 */
	protected function set_markup_fields() {
		return array();
	}

	/**
	 * Function that runs before any class variables are set.
	 *
	 * Exists for extending classes to have an opportunity to set additional properties.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 */
	protected function pre_set() {
		return;
	}

	/**
	 * Add extras properties to class.
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 *
	 * @param array $props 'name' => 'value' pairs of properties to set.
	 */
	private function create_properties( $props){
		foreach ( $props as $name => $value  ) {
			$this->{$name} = $value;
		}

	}




}
