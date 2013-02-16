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

namespace Eventus;

/**
 * Base class for events, extends if necessary.
 *
 * @property-read Dispatcher $dispatcher
 * @property-read string     $name
 */
class Event
{
	/**
	 *
	 */
	function __construct($name)
	{
		$this->_name = $name;
	}

	/**
	 *
	 */
	function __destruct()
	{}

	/**
	 * @param string $name
	 */
	function __get($name)
	{
		if (($name === 'dispatcher')
		    || ($name === 'name'))
		{
			return $this->{'_'.$name};
		}

		trigger_error(
			'no such readable property: '.get_class($this).'->'.$name,
			E_USER_ERROR
		);
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 */
	function __set($name, $value)
	{
		// $dispatcher is assigned only once by the dispatcher.
		if (($name === 'dispatcher')
		    && (null === $this->_dispatcher))
		{
			$this->_dispatcher = $value;
			return;
		}

		trigger_error(
			'no such writable property: '.get_class($this).'->'.$name,
			E_USER_ERROR
		);
	}

	/**
	 * Returns a human-readable description of this event.
	 *
	 * @return string
	 */
	function __toString()
	{
		return 'Eventus event: '.$this->_name.' ('.get_class($this).')';
	}

	/**
	 * @var Dispatcher
	 */
	private $_dispatcher;

	/**
	 * @var string
	 */
	private $_name;
}
