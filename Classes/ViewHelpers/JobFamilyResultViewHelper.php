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
 * Class JobFamilyResultViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class JobFamilyResultViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Returns results of relevant values
     *
     * @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     * @return string
     */
    public function render(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {

        return ($jobFamily->getAgeRisk() / 2.25) . ',' . $jobFamily->getCompetenceRisk() / 2.25 . ',-' . ($jobFamily->getProvisionRisk() / 2.25) . ',-' . ($jobFamily->getCapacityRisk() / 2.25);
        //===
    }


}