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

use RKW\RkwWepstra\Domain\Model\JobFamily;

/**
 * Class JobFamilyResultViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class JobFamilyResultViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('jobFamily', JobFamily::class, 'The jobFamily-object.', true);
    }

    /**
     * Returns results of relevant values
     *
     * @return string
     */
    public function render(): string
    {
        /** @var  \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
        $jobFamily = $this->arguments['jobFamily'];

        return ($jobFamily->getAgeRisk() / 2.25) . ',' . $jobFamily->getCompetenceRisk() / 2.25 . ',-' . ($jobFamily->getProvisionRisk() / 2.25) . ',-' . ($jobFamily->getCapacityRisk() / 2.25);
    }


}
