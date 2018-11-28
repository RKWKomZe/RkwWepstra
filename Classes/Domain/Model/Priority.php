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
 * Priority
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Priority extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * value
     *
     * @var integer
     */
    protected $value = 0;

    /**
     * jobFamily
     *
     * @var \RKW\RkwWepstra\Domain\Model\JobFamily
     */
    protected $jobFamily = null;

    /**
     * participant
     *
     * @var \RKW\RkwWepstra\Domain\Model\Participant
     */
    protected $participant = null;

    /**
     * Returns the value
     *
     * @return integer $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value
     *
     * @param integer $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the jobFamily
     *
     * @return \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     */
    public function getJobFamily()
    {
        return $this->jobFamily;
    }

    /**
     * Sets the jobFamily
     *
     * @param \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     * @return void
     */
    public function setJobFamily(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {
        $this->jobFamily = $jobFamily;
    }

    /**
     * Returns the participant
     *
     * @return \RKW\RkwWepstra\Domain\Model\Participant $participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Sets the participant
     *
     * @param \RKW\RkwWepstra\Domain\Model\Participant $participant
     * @return void
     */
    public function setParticipant(\RKW\RkwWepstra\Domain\Model\Participant $participant)
    {
        $this->participant = $participant;
    }

}