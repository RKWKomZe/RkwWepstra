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
use RKW\RkwWepstra\Domain\Model\Wepstra;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class JobFamilySortNormalViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class JobFamilySortNormalViewHelper extends AbstractViewHelper
{
    /**
     * Returns value of array index
     *
     * @param Wepstra $wepstra
     * @param boolean $odd
     * @return array
     */
    public function render(Wepstra $wepstra)
    {
        $jobFamilies = $wepstra->getJobFamily()->toArray();
        usort($jobFamilies, array($this, "sortByAverageValue"));

        return $jobFamilies;
    }

    /**
     * Sorting method
     *
     * @var JobFamily $a
     * @var JobFamily $b
     * @return int
     */
    private function sortByAverageValue(JobFamily $a, JobFamily $b)
    {
        if ($a->getPriorityAverage() == $b->getPriorityAverage()) {
            return 0;
        }

        return ($a->getPriorityAverage() < $b->getPriorityAverage()) ? 1 : -1;
    }

}