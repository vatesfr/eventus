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

require(__DIR__.'/../vendor/autoload.php');

use \Eventus\Dispatcher;
use \Eventus\Event;

//--------------------------------------

$closure = function (Event $event) {
	echo 'Closure receive: ', $event->name, PHP_EOL;
};

function my_function(Event $event)
{
	echo __FUNCTION__, ' receive:', $event->name, PHP_EOL;
}

class MyClass
{
	function myMethod(Event $event)
	{
		echo __METHOD__, ' receive: ', $event->name, PHP_EOL;
	}
}

//--------------------------------------

// Let's create a new event dispatcher.
$dispatcher = new Dispatcher;


// The listener can be a closure.
$dispatcher->register('my_package.my_event', $closure);

// Or a function.
$dispatcher->register('my_package.my_event', 'my_function');

/* Or a method.
 *
 * In fact it can be anything for which “is_callable()” returns true.
 */
$my_object = new MyClass;
$dispatcher->register(
	'my_package.my_event',
	array($my_object, 'myMethod')
);


// We can finally dispatch an event.
$dispatcher->dispatch(new Event('my_package.my_event'));
