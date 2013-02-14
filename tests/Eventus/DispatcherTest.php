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

final class TestListener
{
	/**
	 * @var null|Event
	 */
	public $event;

	/**
	 *
	 */
	function reset()
	{
		$this->event = null;
	}

	/**
	 * @param Event
	 */
	function listener(Event $event)
	{
		$this->event = $event;
	}
}

//--------------------------------------

/**
 * @covers Dispatcher
 */
final class DispatcherTest extends \PHPUnit_Framework_TestCase
{
	function setUp()
	{
		$this->_dispatcher = new Dispatcher;
	}

	private $_dispatcher;

	////////////////////////////////////////

	/**
	 * @todo Split in multiple tests.
	 */
	function testSingleListener()
	{
		$listener = new TestListener;

		$this->_dispatcher->register(
			'event',
			array($listener, 'listener')
		);

		// No event has been dispatched by register().
		$this->assertNull($listener->event);

		$this->_dispatcher->dispatch(new Event('other_event'));

		// No “crossed” events.
		$this->assertNull($listener->event);

		$event = new Event('event');
		$this->_dispatcher->dispatch($event);

		// Listener has been called and $dispatcher is correctly set.
		$this->assertSame($event, $listener->event);
		$this->assertSame(
			$this->_dispatcher,
			$listener->event->dispatcher
		);

		$listener->reset();

		$this->_dispatcher->unregister('event', array($listener, 'listener'));
		$this->_dispatcher->dispatch(new Event('event'));

		// unregister() worked correctly.
		$this->assertNull($listener->event);
	}
}