<?php

namespace RKW\RkwWepstra\Controller;

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
 * WepstraCommandController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class WepstraCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;


    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $persistenceManager;

    /**
     * wepstraRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\WepstraRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $wepstraRepository = null;

    /**
     * participantRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ParticipantRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $participantRepository = null;

    /**
     * reasonWhyRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ReasonWhyRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $reasonWhyRepository = null;

    /**
     * jobFamilyRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\JobFamilyRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $jobFamilyRepository = null;

    /**
     * priorityRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\PriorityRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $priorityRepository = null;

    /**
     * salesTrendRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\SalesTrendRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $salesTrendRepository = null;

    /**
     * geographicalSectorRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\GeographicalSectorRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $geographicalSectorRepository = null;

    /**
     * productSectorRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ProductSectorRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $productSectorRepository = null;

    /**
     * performanceRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\PerformanceRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $performanceRepository = null;

    /**
     * technicalDevelopmentRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\TechnicalDevelopmentRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $technicalDevelopmentRepository = null;

    /**
     * productivityRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ProductivityRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $productivityRepository = null;

    /**
     * costSavingRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\CostSavingRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $costSavingRepository = null;

    /**
     * graphRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\GraphRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $graphRepository = null;

    /**
     * stepControlRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\StepControlRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $stepControlRepository = null;

    /**
     * frontendUserRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\FrontendUserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $frontendUserRepository;


    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * Initialize the controller.
     */
    protected function initializeController()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
    }


    /**
     * Cleanup abandoned wepstra projects of anonymous users
     * !! DANGER !! Cleanup executes a real MySQL-Delete- Query!!!
     *
     * @param integer $daysFromNow Defines which datasets (in days from now) will be deleted (crdate is reference)
     * @return void
     */
    public function cleanupAbandonedCommand($daysFromNow = 730)
    {

        try {

            if ($cleanupTimestamp = time() - intval($daysFromNow) * 24 * 60 * 60) {

                if (
                    ($wepstraList = $this->wepstraRepository->findAbandoned($cleanupTimestamp))
                    && is_countable($wepstraList)
                    && (count($wepstraList))
                ) {

                    /** @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstraToDelete */
                    foreach ($wepstraList as $wepstra) {
                        $this->deleteWepstra($wepstra);
                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully deleted WePstra-project %s and all its sub-objects.', $wepstra->getUid()));
                    }

                } else {
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Nothing to clean up in database (AbandonedCleanup).');
                }
            }

        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occured: %s', $e->getMessage()));
        }
    }


    /**
     * Deletes a Wepstra-project with all of its sub-objects
     *
     * @param \RKW\RkwWepstra\Domain\Model\Wepstra $wepstraToDelete
     * @return void
     */
    protected function deleteWepstra(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstraToDelete)
    {

        // 1.1 costSaving
        if ($wepstraToDelete->getCostSaving()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\CostSaving $costSaving */
            foreach ($wepstraToDelete->getCostSaving() as $costSaving) {
                $this->costSavingRepository->removeHard($costSaving);
            }
        }

        // 1.2 geographicalSector
        if ($wepstraToDelete->getGeographicalSector()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector */
            foreach ($wepstraToDelete->getGeographicalSector() as $geographicalSector) {
                $this->geographicalSectorRepository->removeHard($geographicalSector);
            }
        }

        // 1.3 jobFamily
        $jobFamilyList = $wepstraToDelete->getJobFamily()->toArray();
        if (
            is_countable($jobFamilyList)
            && count($jobFamilyList)
        ) {
            /** @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
            foreach ($jobFamilyList as $jobFamily) {

                // 1.4 priority
                $priorityList = $this->priorityRepository->findByJobFamilyForCronjob($jobFamily);

                // !! do not make this count here! By any reason the $priorityList is "empty", even it's include a dataset!
                // -> Anyhow it works without this count (no crash if there are no datasets!)
                // -> Simply nothing for the "foreach"-construct delivered
                //if (count($priorityList)) {
                foreach ($priorityList as $priority) {
                    $this->priorityRepository->removeHard($priority);
                }
                //}
                $this->jobFamilyRepository->removeHard($jobFamily);
            }
        }

        // 1.5 participant
        if ($wepstraToDelete->getParticipants()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\Participant $participant */
            foreach ($wepstraToDelete->getParticipants() as $participant) {
                $this->participantRepository->removeHard($participant);
            }
        }

        // 1.6 performance
        if ($wepstraToDelete->getPerformance()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\Performance $performance */
            foreach ($wepstraToDelete->getPerformance() as $performance) {
                $this->performanceRepository->removeHard($performance);
            }
        }

        // 1.7 productivity
        if ($wepstraToDelete->getProductivity()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\Productivity $productivity */
            foreach ($wepstraToDelete->getProductivity() as $productivity) {
                $this->productivityRepository->removeHard($productivity);
            }
        }

        // 1.8 productSector
        if ($wepstraToDelete->getProductSector()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\ProductSector $productSector */
            foreach ($wepstraToDelete->getProductSector() as $productSector) {
                $this->productSectorRepository->removeHard($productSector);
            }
        }

        // 1.9 reasonWhy
        if ($wepstraToDelete->getReasonWhy()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy */
            foreach ($wepstraToDelete->getReasonWhy() as $reasonWhy) {
                $this->reasonWhyRepository->removeHard($reasonWhy);
            }
        }

        // 1.10 salesTrend
        if ($wepstraToDelete->getSalesTrend()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend */
            foreach ($wepstraToDelete->getSalesTrend() as $salesTrend) {
                $this->salesTrendRepository->removeHard($salesTrend);
            }
        }

        // 1.11 technicalDevelopment
        if ($wepstraToDelete->getTechnicalDevelopment()->count()) {
            /** @var \RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment */
            foreach ($wepstraToDelete->getTechnicalDevelopment() as $technicalDevelopment) {
                $this->technicalDevelopmentRepository->removeHard($technicalDevelopment);
            }
        }

        // 1.12 stepControl
        if ($wepstraToDelete->getStepControl()) {
            $this->stepControlRepository->removeHard($wepstraToDelete->getStepControl());
        }

        // 1.13 wepstra itself
        $this->wepstraRepository->removeHard($wepstraToDelete);
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        }

        return $this->logger;
        //===
    }

}
