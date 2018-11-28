<?php

namespace RKW\RkwWepstra\ViewHelpers;

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
 * Class JobFamilyStrategicRelevanceSumViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class JobFamilyStrategicRelevanceSumViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Returns sum of relevant values
     *
     * @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     * @return string
     */
    public function render(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {

        $sum = $jobFamily->getStrategicRelevanceMarket() + $jobFamily->getStrategicRelevanceInnovation() + $jobFamily->getStrategicRelevanceProductivity();
        if ($sum > 9) {
            $sum = 9;
        }

        return $sum;
        //===
    }


}