<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Xavier Perseguers <typo3@perseguers.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * A movie.
 *
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 * @entity
 */
class Tx_MvcExtjsSamples_Domain_Model_Movie extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The movie's title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * The director
	 *
	 * @var string
	 */
	protected $director = '';

	/**
	 * The release date
	 *
	 * @var DateTime
	 */
	protected $releaseDate;
	
	/**
	 * The movie's tagline
	 *
	 * @var string
	 */
	protected $tagline;

	/**
	 * Either 0 ('Color') or 1 ('Black and White')
	 * 
	 * @var integer
	 */
	protected $filmedIn;
	
	/**
	 * Whether the movie is considered bad
	 * 
	 * @var boolean
	 */
	protected $isBad;
	
	/**
	 * The movie's genre
	 *
	 * @var Tx_MvcExtjsSamples_Domain_Model_Genre
	 */
	protected $genre;
	
	/**
	 * Sets this movie's title.
	 *
	 * @param string $title The movie's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the movie's title.
	 *
	 * @return string The movie's title
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Sets this movie's director.
	 *
	 * @param string $director The movie's director
	 * @return void
	 */
	public function setDirector($director) {
		$this->director = $director;
	}
	
	/**
	 * Gets this movie's director.
	 *
	 * @return string The movie's director
	 */
	public function getDirector() {
		return $this->director;
	}
	
	/**
	 * Sets this movie's release date.
	 *
	 * @param DateTime $releaseDate
	 * @return void
	 */
	public function setReleaseDate(DateTime $releaseDate) {
		$this->releaseDate = $releaseDate;
	}
	
	/**
	 * Gets this movie's release date.
	 *
	 * @return DateTime
	 */
	public function getReleaseDate() {
		return $this->releaseDate;
	}
	
	/**
	 * Sets this movie's tagline.
	 *
	 * @param string $tagline
	 * @return void
	 */
	public function setTagline($tagline) {
		$this->tagline = $tagline;
	}
	
	/**
	 * Gets this movie's tagline.
	 * 
	 * @return string
	 */
	public function getTagline() {
		return $this->tagline;
	}
	
	/**
	 * Sets whether the movie was filmed in color (0) or
	 * in black and white (1).
	 *
	 * @param integer $filmedIn Either 0 ('Color') or 1 ('Black and White')
	 * @return void
	 */
	public function setFilmedIn($filmedIn) {
		$this->filmedIn = $filmedIn;
	}
	
	/**
	 * Gets whether the movie was filmed in color or in
	 * black and white.
	 *
	 * @return integer Either 0 ('Color') or 1 ('Black and White')
	 */
	public function getFilmedIn() {
		return $this->filmedIn;
	}
	
	/**
	 * Sets whether this movie is bad.
	 *
	 * @param boolean $isBad
	 * @return void
	 */
	public function setIsBad($isBad) {
		$this->isBad = $isBad;
	}
	
	/**
	 * Gets whether this movie is bad.
	 *
	 * @return boolean
	 */
	public function getIsBad() {
		return $this->isBad;
	}
	
	/**
	 * Sets the movie's genre.
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_Genre $genre
	 * @return void
	 */
	public function setGenre(Tx_MvcExtjsSamples_Domain_Model_Genre $genre) {
		$this->genre = $genre;
	}
	
	/**
	 * Gets the movie's genre.
	 *
	 * @return Tx_MvcExtjsSamples_Domain_Model_Genre
	 */
	public function getGenre() {
		return $this->genre;
	}
}
?>