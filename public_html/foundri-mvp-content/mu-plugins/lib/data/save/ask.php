<?php
/**
 * Save an ask
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data\save;


class ask {

	public static function make_save( $data ) {
		$pods = pods( FOUNDRI_ASK, null );
		$id = $pods->save( $data );

		return $id;

	}

}
