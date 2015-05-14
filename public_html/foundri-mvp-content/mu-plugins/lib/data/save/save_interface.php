<?php
/**
 * Interface for saving Foundri items.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data\save;


interface save_interface {
	/**
	 * Do the actual save
	 *
	 * @todo make work for update
	 *
	 * @since 0.0.1
	 *
	 * @param array $data Data from request.
	 *
	 * @return int|bool Item ID.
	 */
	public static function make_save( $data );

}
