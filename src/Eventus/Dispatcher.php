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
 * Base class for all events, extends if necessary.
 */
final class Dispatcher
{
	/**
	 * @param Event $event
	 */
	function dispatch(Event $event)
	{
		$name = $event->name;
		if (isset($this->_listeners[$name]))
		{
			$event->dispatcher = $this;
			foreach ($this->_listeners[$name] as $listener)
			{
				call_user_func($listener, $event);
			}
		}
	}

	/**
	 * @param string   $event_name
	 * @param callable $listener
	 */
	function register($event_name, $listener)
	{
		$this->_listeners[$event_name][] = $listener;
	}

	/**
	 * @param string   $event_name
	 * @param callable $listener
	 */
	function unregister($event_name, $listener)
	{
		if (!isset($this->_listeners[$event_name]))
		{
			return;
		}

		$key = array_search($listener, $this->_listeners[$event_name], true);
		if (false !== $key)
		{
			unset($this->_listeners[$event_name][$key]);
		}
	}

	/**
	 * @var callable[]
	 */
	private $_listeners = array();
}
