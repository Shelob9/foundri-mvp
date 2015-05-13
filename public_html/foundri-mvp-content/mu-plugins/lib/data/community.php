<?php
/**
 * @TODO What this does.
 *
 * @package   @TODO
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Josh Pollock
 */

namespace foundri\lib\data;


class community {

	public $id;

	/**
	 * @var \Pods|object
	 */
	public $pods;

	public $display_data;

	protected $display_fields = array(
		'post_title' => array(),
		'post_name'=> array(),
		'members' => array(
			'ID',
			'display_name',
		),
		'asks' => array(
			'name',
			'created',
			'modified',
			'author' => array(
				'ID',
				'display_name'
			)
		),
		'logo' => array(),
		'location' => array(),
	);

	public $json_data;

	public function __construct( $id, $markup_fields = false ) {
		$this->set_id( $id );
		$this->set_pods_object();
		$this->set_public_data( $markup_fields );
		$this->set_json_data();

	}

	protected function set_public_data( $markup_fields ) {
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

		if( $markup_fields ) {
			$this->display_data = array_merge( $data, $this->set_markup_fields() );
		}else{
			$this->display_fields = $data;
		}


	}

	/**
	 * @return array
	 */
	protected function set_markup_fields() {
		$fields = array(
			'forms' => array(
				'make_ask' => \Caldera_Forms::render_form( 'ask_make' ),
				'community_search' => \Caldera_Forms::render_form( 'community_search' ),
			),
		);

		return $fields;
	}

	protected function set_id( $id ) {
		$this->id = (int) $id;
	}

	/**
	 *
	 */
	protected function set_pods_object() {
		$params = array(
			'expires' => MINUTE_IN_SECONDS,
			'cache_mode' => 'cache',
		);

		if ( 0 < $this->id ) {
			$params[ 'where' ] = sprintf( 't.ID = "%d"', $this->id );
		}

		$this->pods = pods( FOUNDRI_COMMUNITY, $params );

	}

	protected function set_json_data() {
		$this->json_data = wp_json_encode( $this->display_data );
	}



}
