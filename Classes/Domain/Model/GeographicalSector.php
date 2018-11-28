<?php

namespace RKW\RkwWepstra\Domain\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * GeographicalSector
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GeographicalSector extends \RKW\RkwWepstra\Domain\Model\Item
{
    /**
     * percentage
     *
     * @var integer
     */
    protected $percentage = 0;

    /**
     * currentSales
     *
     * @var integer
     */
    protected $currentSales = 0;

    /**
     * futureSales
     *
     * @var integer
     */
    protected $futureSales = 0;

    /**
     * Returns the percentage
     *
     * @return integer $percentage
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Sets the percentage
     *
     * @param integer $percentage
     * @return void
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * Returns the currentSales
     *
     * @return integer $currentSales
     */
    public function getCurrentSales()
    {
        return $this->currentSales;
    }

    /**
     * Sets the currentSales
     *
     * @param integer $currentSales
     * @return void
     */
    public function setCurrentSales($currentSales)
    {
        $this->currentSales = $currentSales;
    }

    /**
     * Returns the futureSales
     *
     * @return integer $futureSales
     */
    public function getFutureSales()
    {
        return $this->futureSales;
    }

    /**
     * Sets the futureSales
     *
     * @param integer $futureSales
     * @return void
     */
    public function setFutureSales($futureSales)
    {
        $this->futureSales = $futureSales;
    }

}