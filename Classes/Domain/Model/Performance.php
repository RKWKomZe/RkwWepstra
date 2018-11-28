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
 * Performance
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Performance extends \RKW\RkwWepstra\Domain\Model\Item
{
    /**
     * influence
     *
     * @var integer
     */
    protected $influence = 0;

    /**
     * knowledge
     *
     * @var integer
     */
    protected $knowledge = 0;

    /**
     * type
     *
     * @var integer
     */
    protected $type = 0;

    /**
     * Returns the influence
     *
     * @return integer $influence
     */
    public function getInfluence()
    {
        return $this->influence;
    }

    /**
     * Sets the influence
     *
     * @param integer $influence
     * @return void
     */
    public function setInfluence($influence)
    {
        $this->influence = $influence;
    }

    /**
     * Returns the knowledge
     *
     * @return integer $knowledge
     */
    public function getKnowledge()
    {
        return $this->knowledge;
    }

    /**
     * Sets the knowledge
     *
     * @param integer $knowledge
     * @return void
     */
    public function setKnowledge($knowledge)
    {
        $this->knowledge = $knowledge;
    }

    /**
     * Returns the type
     *
     * @return integer $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param integer $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}