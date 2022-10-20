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
 * Wepstra
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Wepstra extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * crdate
     *
     * @var integer
     */
    protected $crdate;

    /**
     * tstamp
     *
     * @var integer
     */
    protected $tstamp;

    /**
     * lastUpdate
     *
     * @var integer
     */
    protected $lastUpdate = 0;

    /**
     * hidden
     *
     * @var integer
     */
    protected $hidden = 0;

    /**
     * disabled
     *
     * @var integer
     */
    protected $disabled = 0;

    /**
     * guidedMode
     *
     * @var integer
     */
    protected $guidedMode = 0;

    /**
     * guidedAsked
     *
     * @var integer
     */
    protected $guidedAsked = 0;

    /**
     * knowledge
     *
     * @var integer
     */
    protected $knowledge = 0;

    /**
     * technicalDevelopmentPercentage
     *
     * @var integer
     */
    protected $technicalDevelopmentPercentage = 0;

    /**
     * targetDate
     * HAVE TO BE A STRING!!! DON'T CHANGE TO INTEGER!
     *
     * @var string
     */
    protected $targetDate = 0;


    /**
     * reasonWhy
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\ReasonWhy>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $reasonWhy = null;

    /**
     * salesTrend
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\SalesTrend>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $salesTrend = null;

    /**
     * geographicalSector
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\GeographicalSector>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $geographicalSector = null;

    /**
     * productSector
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\ProductSector>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $productSector = null;

    /**
     * performance
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Performance>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $performance = null;

    /**
     * technicalDevelopment
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $technicalDevelopment = null;

    /**
     * productivity
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Productivity>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $productivity = null;

    /**
     * costSaving
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\CostSaving>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $costSaving = null;

    /**
     * participants
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Participant>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $participants = null;

    /**
     * jobFamily
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\JobFamily>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $jobFamily = null;

    /**
     * stepControl
     *
     * @var \RKW\RkwWepstra\Domain\Model\StepControl
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $stepControl = null;

    /**
     * frontendUser
     *
     * @var \RKW\RkwRegistration\Domain\Model\FrontendUser
     */
    protected $frontendUser = null;

    /**
     * anonymousUser
     *
     * @var \RKW\RkwWepstra\Domain\Model\FrontendUser
     */
    protected $anonymousUser = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();

        $this->initSubdomains();
    }


    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->reasonWhy = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->salesTrend = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->geographicalSector = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->productSector = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->performance = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->technicalDevelopment = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->productivity = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->costSaving = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->participants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->jobFamily = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initSubdomains()
    {
        $this->stepControl = new \RKW\RkwWepstra\Domain\Model\StepControl;
    }


    /**
     * Returns the lastUpdate
     *
     * @return integer $lastUpdate
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Sets the lastUpdate
     *
     * @param integer $lastUpdate
     * @return void
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * Returns the tstamp
     *
     * @return integer $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Sets the tstamp
     *
     * @param integer $tstamp
     * @return void
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Returns the hidden
     *
     * @return integer $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets the hidden
     *
     * @param integer $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the disabled
     *
     * @return integer $disabled
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Sets the disabled
     *
     * @param integer $disabled
     * @return void
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    /**
     * Returns the guidedMode
     *
     * @return integer $guidedMode
     */
    public function getGuidedMode()
    {
        return $this->guidedMode;
    }

    /**
     * Sets the guidedMode
     *
     * @param integer $guidedMode
     * @return void
     */
    public function setGuidedMode($guidedMode)
    {
        $this->guidedMode = $guidedMode;
    }

    /**
     * Returns the guidedAsked
     *
     * @return integer $guidedAsked
     */
    public function getGuidedAsked()
    {
        return $this->guidedAsked;
    }

    /**
     * Sets the guidedAsked
     *
     * @param integer $guidedAsked
     * @return void
     */
    public function setGuidedAsked($guidedAsked)
    {
        $this->guidedAsked = $guidedAsked;
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
     * Returns the targetDate
     *
     * @return string $targetDate
     */
    public function getTargetDate()
    {
        return $this->targetDate;
    }

    /**
     * Sets the targetDate
     *
     * @param string $targetDate
     * @return void
     */
    public function setTargetDate($targetDate)
    {
        $this->targetDate = $targetDate;
    }

    /**
     * Returns the crdate
     *
     * @return integer $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Sets the crdate
     *
     * @param integer $crdate
     * @return void
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the technicalDevelopmentPercentage
     *
     * @return integer $technicalDevelopmentPercentage
     */
    public function getTechnicalDevelopmentPercentage()
    {
        return $this->technicalDevelopmentPercentage;
    }

    /**
     * Sets the technicalDevelopmentPercentage
     *
     * @param integer $technicalDevelopmentPercentage
     * @return void
     */
    public function setTechnicalDevelopmentPercentage($technicalDevelopmentPercentage)
    {
        $this->technicalDevelopmentPercentage = $technicalDevelopmentPercentage;
    }

    /**
     * Adds a ReasonWhy
     *
     * @param \RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy
     * @return void
     */
    public function addReasonWhy(\RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy)
    {
        $this->reasonWhy->attach($reasonWhy);
    }

    /**
     * Removes a ReasonWhy
     *
     * @param \RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhyToRemove The ReasonWhy to be removed
     * @return void
     */
    public function removeReasonWhy(\RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhyToRemove)
    {
        $this->reasonWhy->detach($reasonWhyToRemove);
    }

    /**
     * Returns the reasonWhy
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\ReasonWhy> $reasonWhy
     */
    public function getReasonWhy()
    {
        return $this->reasonWhy;
    }

    /**
     * Sets the reasonWhy
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\ReasonWhy> $reasonWhy
     * @return void
     */
    public function setReasonWhy(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $reasonWhy)
    {
        $this->reasonWhy = $reasonWhy;
    }

    /**
     * Adds a SalesTrend
     *
     * @param \RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend
     * @return void
     */
    public function addSalesTrend(\RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend)
    {
        $this->salesTrend->attach($salesTrend);
    }

    /**
     * Removes a SalesTrend
     *
     * @param \RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrendToRemove The SalesTrend to be removed
     * @return void
     */
    public function removeSalesTrend(\RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrendToRemove)
    {
        $this->salesTrend->detach($salesTrendToRemove);
    }

    /**
     * Returns the salesTrend
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\SalesTrend> $salesTrend
     */
    public function getSalesTrend()
    {
        return $this->salesTrend;
    }

    /**
     * Sets the salesTrend
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\SalesTrend> $salesTrend
     * @return void
     */
    public function setSalesTrend(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $salesTrend)
    {
        $this->salesTrend = $salesTrend;
    }

    /**
     * Adds a GeographicalSector
     *
     * @param \RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector
     * @return void
     */
    public function addGeographicalSector(\RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector)
    {
        $this->geographicalSector->attach($geographicalSector);
    }

    /**
     * Removes a GeographicalSector
     *
     * @param \RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSectorToRemove The GeographicalSector to be removed
     * @return void
     */
    public function removeGeographicalSector(\RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSectorToRemove)
    {
        $this->geographicalSector->detach($geographicalSectorToRemove);
    }

    /**
     * Returns the geographicalSector
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\GeographicalSector> $geographicalSector
     */
    public function getGeographicalSector()
    {
        return $this->geographicalSector;
    }

    /**
     * Sets the geographicalSector
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\GeographicalSector> $geographicalSector
     * @return void
     */
    public function setGeographicalSector(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $geographicalSector)
    {
        $this->geographicalSector = $geographicalSector;
    }

    /**
     * Adds a ProductSector
     *
     * @param \RKW\RkwWepstra\Domain\Model\ProductSector $productSector
     * @return void
     */
    public function addProductSector(\RKW\RkwWepstra\Domain\Model\ProductSector $productSector)
    {
        $this->productSector->attach($productSector);
    }

    /**
     * Removes a ProductSector
     *
     * @param \RKW\RkwWepstra\Domain\Model\ProductSector $productSectorToRemove The ProductSector to be removed
     * @return void
     */
    public function removeProductSector(\RKW\RkwWepstra\Domain\Model\ProductSector $productSectorToRemove)
    {
        $this->productSector->detach($productSectorToRemove);
    }

    /**
     * Returns the productSector
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\ProductSector> $productSector
     */
    public function getProductSector()
    {
        return $this->productSector;
    }

    /**
     * Sets the productSector
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\ProductSector> $productSector
     * @return void
     */
    public function setProductSector(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $productSector)
    {
        $this->productSector = $productSector;
    }

    /**
     * Adds a Performance
     *
     * @param \RKW\RkwWepstra\Domain\Model\Performance $performance
     * @return void
     */
    public function addPerformance(\RKW\RkwWepstra\Domain\Model\Performance $performance)
    {
        $this->performance->attach($performance);
    }

    /**
     * Removes a Performance
     *
     * @param \RKW\RkwWepstra\Domain\Model\Performance $performanceToRemove The Performance to be removed
     * @return void
     */
    public function removePerformance(\RKW\RkwWepstra\Domain\Model\Performance $performanceToRemove)
    {
        $this->performance->detach($performanceToRemove);
    }

    /**
     * Returns the performance
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Performance> $performance
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * Sets the performance
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Performance> $performance
     * @return void
     */
    public function setPerformance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $performance)
    {
        $this->performance = $performance;
    }

    /**
     * Adds a TechnicalDevelopment
     *
     * @param \RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment
     * @return void
     */
    public function addTechnicalDevelopment(\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment)
    {
        $this->technicalDevelopment->attach($technicalDevelopment);
    }

    /**
     * Removes a TechnicalDevelopment
     *
     * @param \RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopmentToRemove The TechnicalDevelopment to be
     *     removed
     * @return void
     */
    public function removeTechnicalDevelopment(\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopmentToRemove)
    {
        $this->technicalDevelopment->detach($technicalDevelopmentToRemove);
    }

    /**
     * Returns the technicalDevelopment
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment> $technicalDevelopment
     */
    public function getTechnicalDevelopment()
    {
        return $this->technicalDevelopment;
    }

    /**
     * Sets the technicalDevelopment
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment> $technicalDevelopment
     * @return void
     */
    public function setTechnicalDevelopment(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $technicalDevelopment)
    {
        $this->technicalDevelopment = $technicalDevelopment;
    }

    /**
     * Adds a Productivity
     *
     * @param \RKW\RkwWepstra\Domain\Model\Productivity $productivity
     * @return void
     */
    public function addProductivity(\RKW\RkwWepstra\Domain\Model\Productivity $productivity)
    {
        $this->productivity->attach($productivity);
    }

    /**
     * Removes a Productivity
     *
     * @param \RKW\RkwWepstra\Domain\Model\Productivity $productivityToRemove The Productivity to be removed
     * @return void
     */
    public function removeProductivity(\RKW\RkwWepstra\Domain\Model\Productivity $productivityToRemove)
    {
        $this->productivity->detach($productivityToRemove);
    }

    /**
     * Returns the productivity
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Productivity> $productivity
     */
    public function getProductivity()
    {
        return $this->productivity;
    }

    /**
     * Sets the productivity
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Productivity> $productivity
     * @return void
     */
    public function setProductivity(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $productivity)
    {
        $this->productivity = $productivity;
    }

    /**
     * Adds a CostSaving
     *
     * @param \RKW\RkwWepstra\Domain\Model\CostSaving $costSaving
     * @return void
     */
    public function addCostSaving(\RKW\RkwWepstra\Domain\Model\CostSaving $costSaving)
    {
        $this->costSaving->attach($costSaving);
    }

    /**
     * Removes a CostSaving
     *
     * @param \RKW\RkwWepstra\Domain\Model\CostSaving $costSavingToRemove The CostSaving to be removed
     * @return void
     */
    public function removeCostSaving(\RKW\RkwWepstra\Domain\Model\CostSaving $costSavingToRemove)
    {
        $this->costSaving->detach($costSavingToRemove);
    }

    /**
     * Returns the costSaving
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\CostSaving> $costSaving
     */
    public function getCostSaving()
    {
        return $this->costSaving;
    }

    /**
     * Sets the costSaving
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\CostSaving> $costSaving
     * @return void
     */
    public function setCostSaving(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $costSaving)
    {
        $this->costSaving = $costSaving;
    }

    /**
     * Adds a Participant
     *
     * @param \RKW\RkwWepstra\Domain\Model\Participant $participant
     * @return void
     */
    public function addParticipant(\RKW\RkwWepstra\Domain\Model\Participant $participant)
    {
        $this->participants->attach($participant);
    }

    /**
     * Removes a Participant
     *
     * @param \RKW\RkwWepstra\Domain\Model\Participant $participantToRemove The Participant to be removed
     * @return void
     */
    public function removeParticipant(\RKW\RkwWepstra\Domain\Model\Participant $participantToRemove)
    {
        $this->participants->detach($participantToRemove);
    }

    /**
     * Returns the participants
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Participant> $participants
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Sets the participants
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\Participant> $participants
     * @return void
     */
    public function setParticipants(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $participants)
    {
        $this->participants = $participants;
    }

    /**
     * Adds a JobFamily
     *
     * @param \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     * @return void
     */
    public function addJobFamily(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {
        $this->jobFamily->attach($jobFamily);
    }

    /**
     * Removes a JobFamily
     *
     * @param \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamilyToRemove The JobFamily to be removed
     * @return void
     */
    public function removeJobFamily(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamilyToRemove)
    {
        $this->jobFamily->detach($jobFamilyToRemove);
    }

    /**
     * Returns the jobFamily
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\JobFamily> $jobFamily
     */
    public function getJobFamily()
    {
        return $this->jobFamily;
    }

    /**
     * Sets the jobFamily
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwWepstra\Domain\Model\JobFamily> $jobFamily
     * @return void
     */
    public function setJobFamily(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $jobFamily)
    {
        $this->jobFamily = $jobFamily;
    }

    /**
     * Returns the stepControl
     *
     * @return \RKW\RkwWepstra\Domain\Model\StepControl $stepControl
     */
    public function getStepControl()
    {
        return $this->stepControl;
    }

    /**
     * Sets the stepControl
     *
     * @param \RKW\RkwWepstra\Domain\Model\StepControl $stepControl
     * @return void
     */
    public function setGraph(\RKW\RkwWepstra\Domain\Model\StepControl $stepControl)
    {
        $this->stepControl = $stepControl;
    }

    /**
     * Returns the frontendUser
     *
     * @return \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     */
    public function getFrontendUser()
    {
        return $this->frontendUser;
    }

    /**
     * Sets the frontendUser
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @return void
     */
    public function setFrontendUser(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser)
    {
        $this->frontendUser = $frontendUser;
    }

    /**
     * Returns the anonymousUser
     *
     * @return \RKW\RkwWepstra\Domain\Model\FrontendUser $anonymousUser
     */
    public function getAnonymousUser()
    {
        return $this->anonymousUser;
    }

    /**
     * Sets the anonymousUser
     *
     * @param \RKW\RkwWepstra\Domain\Model\FrontendUser $anonymousUser
     * @return void
     */
    public function setAnonymousUser(\RKW\RkwWepstra\Domain\Model\FrontendUser $anonymousUser)
    {
        $this->anonymousUser = $anonymousUser;
    }

    /**
     * Sets the anonymousUser
     *
     * @return void
     */
    public function unsetAnonymousUser()
    {
        $this->anonymousUser = null;
    }

}
