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
 * Class ReadArrayIndexViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ReadArrayIndexViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('array', 'array', 'The recursive array.', true);
        $this->registerArgument('index1', 'array', 'The index on the first level for array.', true);
        $this->registerArgument('index2', 'array', 'The index on the second level for array.', true);
    }

    /**
     * Returns value of array index
     *
     * @return mixed
     */
    public function render()
    {
        /** @var array $array */
        $array = $this->arguments['array'];

        /** @var int $index1 */
        $index1 = $this->arguments['index1'];

        /** @var int $index2 */
        $index2 = $this->arguments['index2'];

        return $array[$index1][$index2];
    }


}
