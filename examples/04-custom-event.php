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

/**
 * You may define your own event types.
 */
final class AlbumAddedEvent extends Event
{
	const NAME = 'my_package.album.added';

	public $title;
	public $artist;

	function __construct($title, $artist)
	{
		parent::__construct(self::NAME);

		$this->title  = $title;
		$this->artist = $artist;
	}
}

$listener = function (AlbumAddedEvent $event) {
	echo
		'The album “', $event->title, '” by “',
		$event->artist, '” has been added.',
		PHP_EOL;
};

//--------------------------------------

// Let's create a new event dispatcher.
$dispatcher = new Dispatcher;

// Registers our listener.
$dispatcher->register(AlbumAddedEvent::NAME, $listener);

// Creates and dispatch our event.
$event = new AlbumAddedEvent('Thriller', 'Michael Jackson');
$dispatcher->dispatch($event);
