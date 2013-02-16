<?php
/**
 * This file is a part of Eventus.
 *
 * Eventus is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Eventus is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Eventus. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Julien Fontanet <julien.fontanet@vates.fr>
 * @license http://www.gnu.org/licenses/gpl-3.0-standalone.html GPLv3
 *
 * @package Eventus
 */

namespace Eventus\Event;

use Eventus\Event;

/**
 * This generic event permits you to store any data like a standard
 * PHP array.
 *
 * Note: This class has been inspired by
 * Symfony\Component\EventDispatcher\GenericEvent.
 */
final class Generic extends Event implements
	\ArrayAccess,
	\Countable,
	\IteratorAggregate
{
	/**
	 *
	 */
	function __construct($name, array $data = array())
	{
		parent::__construct($name);

		$this->_data = $data;
	}

	/**
	 * @var array
	 */
	private $_data;

	//--------------------------------------

	/**
	 *
	 */
	function offsetGet($offset)
	{
		if (!$this->offsetExists($offset))
		{
			trigger_error(
				'no such offset',
				E_USER_ERROR
			);
		}

		return $this->_data[$offset];
	}

	/**
	 *
	 */
	function offsetExists($offset)
	{
		return (isset($this->_data[$offset])
		        || array_key_exists($offset, $this->_data));
	}

	/**
	 *
	 */
	function offsetSet($offset, $value)
	{
		$this->_data[$offset] = $value;
	}

	/**
	 *
	 */
	function offsetUnset($index)
	{
		unset($this->_data[$index]);
	}

	//--------------------------------------

	/**
	 * @return integer
	 */
	function count()
	{
		return count($this->_data);
	}

	//--------------------------------------

	/**
	 *
	 */
	function getIterator()
	{
		return \ArrayIterator($this->_data);
	}
}
