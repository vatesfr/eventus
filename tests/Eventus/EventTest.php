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

namespace Test\Eventus;

use Eventus\Dispatcher;
use Eventus\Event;

//--------------------------------------

/**
 * @covers \Eventus\Event
 */
final class EventTest extends \PHPUnit_Framework_TestCase
{
	function setUp()
	{
		$this->_event = new Event('event');
	}

	private $_event;

	////////////////////////////////////////

	function testSetName()
	{
		$this->setExpectedException('\PHPUnit_Framework_Error');

		$this->_event->name = 'other_event';
	}

	function testGetName()
	{
		$this->assertSame('event', $this->_event->name);
	}

	//--------------------------------------

	function testSetDispatcher()
	{
		$dispatcher = new Dispatcher;

		$this->_event->dispatcher = $dispatcher;

		// Assignments worked.
		$this->assertSame(
			$dispatcher,
			$this->_event->dispatcher
		);

		// Cannot be assigned more than once.
		$this->setExpectedException('\PHPUnit_Framework_Error');

		$this->_event->dispatcher = $dispatcher;
	}

	function testGetDispatcher()
	{
		$this->assertNull($this->_event->dispatcher);
	}

	//--------------------------------------

	function testSetInexistentProperty()
	{
		$this->setExpectedException('\PHPUnit_Framework_Error');

		$this->_event->inexistent = 'anything';
	}

	function testGetInexistentProperty()
	{
		$this->setExpectedException('\PHPUnit_Framework_Error');

		$anything = $this->_event->inexistent;
	}
}
