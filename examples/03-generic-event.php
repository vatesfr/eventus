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
use \Eventus\Event\Generic;

//--------------------------------------

/* A generic event allows you to store any data like a standard PHP
 * array.
 */
$listener = function (Generic $event) {
	echo
		'User added: ', $event['name'],
		' (born ', $event['birth'], ')',
		PHP_EOL;
};

//--------------------------------------

// Let's create a new event dispatcher.
$dispatcher = new Dispatcher;

// Registers our listener.
$dispatcher->register('my_package.user.added', $listener);

// Creates and dispatch our generic event.
$event = new Generic('my_package.user.added', array(
	'name'  => 'Nicolas Tesla',
	'birth' => '1856-07-10',
));
$dispatcher->dispatch($event);
