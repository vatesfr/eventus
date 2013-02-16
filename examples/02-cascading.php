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

/* This listener prints the received event then dispatch another event
 * ('my_package.my_event_2').
 */
$listener1 = function (Event $event) {
	echo 'Listener 1: ', $event->name, PHP_EOL;
	$event->dispatcher->dispatch(new Event('my_package.my_event_2'));
};

// This listener just print the received event.
$listener2 = function (Event $event) {
	echo 'Listener 2: ', $event->name, PHP_EOL;
};

//--------------------------------------

// Let's create a new event dispatcher.
$dispatcher = new Dispatcher;

// Registers our listeners.
$dispatcher->register('my_package.my_event_1', $listener1);
$dispatcher->register('my_package.my_event_2', $listener2);

// Dispatch the first event to trigger the cascading reaction.
$dispatcher->dispatch(new Event('my_package.my_event_1'));
