<?php
/**
 * Process forms
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri_mvp_lib\forms\process;


class process {
	public function __construct() {
		add_action( 'caldera_forms_submit_complete', array( $this, 'route' ), 55 );
	}

	public function route( $form ) {

	}


}
