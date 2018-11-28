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
 * JobFamily
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class JobFamily extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * strategicRelevanceMarket
     *
     * @var integer
     */
    protected $strategicRelevanceMarket = 0;

    /**
     * strategicRelevanceInnovation
     *
     * @var integer
     */
    protected $strategicRelevanceInnovation = 0;

    /**
     * strategicRelevanceProductivity
     *
     * @var integer
     */
    protected $strategicRelevanceProductivity = 0;


    /**
     * ageRisk
     *
     * @var float
     */
    protected $ageRisk = 0;

    /**
     * capacityRisk
     *
     * @var float
     */
    protected $capacityRisk = 0;

    /**
     * competenceRisk
     *
     * @var float
     */
    protected $competenceRisk = 0;

    /**
     * provisionRisk
     *
     * @var float
     */
    protected $provisionRisk = 0;

    /**
     * taskMarketing
     *
     * @var string
     */
    protected $taskMarketing = '';

    /**
     * taskSourcing
     *
     * @var string
     */
    protected $taskSourcing = '';

    /**
     * taskIntegration
     *
     * @var string
     */
    protected $taskIntegration = '';

    /**
     * taskLoyalty
     *
     * @var string
     */
    protected $taskLoyalty = '';

    /**
     * taskTrend
     *
     * @var string
     */
    protected $taskTrend = '';

    /**
     * taskEmployment
     *
     * @var string
     */
    protected $taskEndingEmployment = '';

    /**
     * priority
     *
     * @var string
     */
    protected $priorityAverage = 0;

    /**
     * selected
     *
     * @var integer
     */
    protected $selected = 0;

    /**
     * updateTask
     *
     * @var int
     */
    protected $updateTask = 0;


    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /** ==================================
     * Average from rating in step 2
     * ===================================
     */

    /**
     * Returns the priorityAverage
     *
     * @return string $priorityAverage
     */
    public function getPriorityAverage()
    {
        return $this->priorityAverage;
    }

    /**
     * Sets the priorityAverage
     *
     * @param string $priorityAverage
     * @return void
     */
    public function setPriorityAverage($priorityAverage)
    {
        $this->priorityAverage = $priorityAverage;
    }


    /** ==================================
     * If job-family has been selected in step 2
     * ===================================
     */

    /**
     * Returns the selected
     *
     * @return integer $selected
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * Sets the selected
     *
     * @param integer $selected
     * @return void
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }


    /** ==================================
     * Ratings for strategic relevance in step 4
     * ===================================
     */

    /**
     * Returns the strategicRelevanceMarket
     *
     * @return integer $strategicRelevanceMarket
     */
    public function getStrategicRelevanceMarket()
    {
        return $this->strategicRelevanceMarket;
    }

    /**
     * Sets the strategicRelevanceMarket
     *
     * @param integer $strategicRelevanceMarket
     * @return void
     */
    public function setStrategicRelevanceMarket($strategicRelevanceMarket)
    {
        $this->strategicRelevanceMarket = $strategicRelevanceMarket;
    }

    /**
     * Returns the strategicRelevanceInnovation
     *
     * @return integer $strategicRelevanceInnovation
     */
    public function getStrategicRelevanceInnovation()
    {
        return $this->strategicRelevanceInnovation;
    }

    /**
     * Sets the strategicRelevanceInnovation
     *
     * @param integer $strategicRelevanceInnovation
     * @return void
     */
    public function setStrategicRelevanceInnovation($strategicRelevanceInnovation)
    {
        $this->strategicRelevanceInnovation = $strategicRelevanceInnovation;
    }

    /**
     * Returns the strategicRelevanceProductivity
     *
     * @return integer $strategicRelevanceProductivity
     */
    public function getStrategicRelevanceProductivity()
    {
        return $this->strategicRelevanceProductivity;
    }

    /**
     * Sets the strategicRelevanceProductivity
     *
     * @param integer $strategicRelevanceProductivity
     * @return void
     */
    public function setStrategicRelevanceProductivity($strategicRelevanceProductivity)
    {
        $this->strategicRelevanceProductivity = $strategicRelevanceProductivity;
    }


    /** ==================================
     * Ratings in step 5
     * ===================================
     */

    /**
     * Returns the ageRisk
     *
     * @return float $ageRisk
     */
    public function getAgeRisk()
    {
        return $this->ageRisk;
    }

    /**
     * Sets the ageRisk
     *
     * @param float $ageRisk
     * @return void
     */
    public function setAgeRisk($ageRisk)
    {
        $this->ageRisk = $ageRisk;
    }

    /**
     * Returns the capacityRisk
     *
     * @return float $capacityRisk
     */
    public function getCapacityRisk()
    {
        return $this->capacityRisk;
    }

    /**
     * Sets the capacityRisk
     *
     * @param float $capacityRisk
     * @return void
     */
    public function setCapacityRisk($capacityRisk)
    {
        $this->capacityRisk = $capacityRisk;
    }

    /**
     * Returns the competenceRisk
     *
     * @return float $competenceRisk
     */
    public function getCompetenceRisk()
    {
        return $this->competenceRisk;
    }

    /**
     * Sets the competenceRisk
     *
     * @param float $competenceRisk
     * @return void
     */
    public function setCompetenceRisk($competenceRisk)
    {
        $this->competenceRisk = $competenceRisk;
    }


    /**
     * Returns the provisionRisk
     *
     * @return float $provisionRisk
     */
    public function getProvisionRisk()
    {
        return $this->provisionRisk;
    }

    /**
     * Sets the provisionRisk
     *
     * @param float $provisionRisk
     * @return void
     */
    public function setProvisionRisk($provisionRisk)
    {
        $this->provisionRisk = $provisionRisk;
    }


    /** ==================================
     * Planing matrix fields in step 6
     * ===================================
     */

    /**
     * Returns the taskMarketing
     *
     * @return string $taskMarketing
     */
    public function getTaskMarketing()
    {
        return $this->taskMarketing;
    }

    /**
     * Sets the taskMarketing
     *
     * @param string $taskMarketing
     * @return void
     */
    public function setTaskMarketing($taskMarketing)
    {
        $this->taskMarketing = $taskMarketing;
    }

    /**
     * Returns the taskSourcing
     *
     * @return string $taskSourcing
     */
    public function getTaskSourcing()
    {
        return $this->taskSourcing;
    }

    /**
     * Sets the taskSourcing
     *
     * @param string $taskSourcing
     * @return void
     */
    public function setTaskSourcing($taskSourcing)
    {
        $this->taskSourcing = $taskSourcing;
    }

    /**
     * Returns the taskIntegration
     *
     * @return string $taskIntegration
     */
    public function getTaskIntegration()
    {
        return $this->taskIntegration;
    }

    /**
     * Sets the taskIntegration
     *
     * @param string $taskIntegration
     * @return void
     */
    public function setTaskIntegration($taskIntegration)
    {
        $this->taskIntegration = $taskIntegration;
    }

    /**
     * Returns the taskLoyalty
     *
     * @return string $taskLoyalty
     */
    public function getTaskLoyalty()
    {
        return $this->taskLoyalty;
    }

    /**
     * Sets the taskLoyalty
     *
     * @param string $taskLoyalty
     * @return void
     */
    public function setTaskLoyalty($taskLoyalty)
    {
        $this->taskLoyalty = $taskLoyalty;
    }

    /**
     * Returns the taskTrend
     *
     * @return string $taskTrend
     */
    public function getTaskTrend()
    {
        return $this->taskTrend;
    }

    /**
     * Sets the taskTrend
     *
     * @param string $taskTrend
     * @return void
     */
    public function setTaskTrend($taskTrend)
    {
        $this->taskTrend = $taskTrend;
    }

    /**
     * Returns the taskEndingEmployment
     *
     * @return string $taskEndingEmployment
     */
    public function getTaskEndingEmployment()
    {
        return $this->taskEndingEmployment;
    }

    /**
     * Sets the taskEndingEmployment
     *
     * @param string $taskEndingEmployment
     * @return void
     */
    public function setTaskEndingEmployment($taskEndingEmployment)
    {
        $this->taskEndingEmployment = $taskEndingEmployment;
    }

    /**
     * Returns the updateTask
     *
     * @return integer $updateTask
     */
    public function getUpdateTask()
    {
        return $this->updateTask;
    }

    /**
     * Sets the updateTask
     *
     * @param integer $updateTask
     * @return void
     */
    public function setUpdateTask($updateTask)
    {
        $this->updateTask = $updateTask;
    }


}
