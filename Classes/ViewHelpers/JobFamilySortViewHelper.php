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
 * Class JobFamilySortViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class JobFamilySortViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{



    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('wepstra', Wepstra::class, 'The wepstra-object.', true);
        $this->registerArgument('odd', 'bool', 'Splitting in odd and even.', false, false);
    }


    /**
     * Returns value of array index
     * Edit Fäßler: We need to split the jobFamily list in odd or even
     *
     * @return array
     */
    public function render(): array
    {

        /** @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra */
        $wepstra = $this->arguments['wepstra'];

        /** @var bool $odd */
        $odd = $this->arguments['odd'];

        $jobFamilies = $wepstra->getJobFamily()->toArray();
        usort($jobFamilies, array($this, "sortByAverageValue"));


        // edit Fäßler begin
        $jobFamilySplitArray = array();

        foreach ($jobFamilies as $key => $jobFamily) {

            // even
            if (!$odd) {
                if ($key % 2 == 0 || $key == 0) {
                    $jobFamilySplitArray[] = $jobFamily;
                }
            }

            // odd
            if ($odd) {
                if ($key % 2 != 0) {
                    $jobFamilySplitArray[] = $jobFamily;
                }
            }

        }

        // edit Fäßler end
        return $jobFamilySplitArray;
    }

    /**
     * Sorting method
     *
     * @var \RKW\RkwWepstra\Domain\Model\JobFamily $a
     * @var \RKW\RkwWepstra\Domain\Model\JobFamily $b
     * @return array
     */
    private function sortByAverageValue(\RKW\RkwWepstra\Domain\Model\JobFamily $a, \RKW\RkwWepstra\Domain\Model\JobFamily $b)
    {

        if ($a->getPriorityAverage() == $b->getPriorityAverage()) {
            return 0;
        }

        return ($a->getPriorityAverage() < $b->getPriorityAverage()) ? 1 : -1;
    }


}
