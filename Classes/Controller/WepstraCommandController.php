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
     * @inject
     */
    protected $persistenceManager;

    /**
     * wepstraRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\WepstraRepository
     * @inject
     */
    protected $wepstraRepository = null;

    /**
     * participantRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ParticipantRepository
     * @inject
     */
    protected $participantRepository = null;

    /**
     * reasonWhyRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ReasonWhyRepository
     * @inject
     */
    protected $reasonWhyRepository = null;

    /**
     * jobFamilyRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\JobFamilyRepository
     * @inject
     */
    protected $jobFamilyRepository = null;

    /**
     * priorityRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\PriorityRepository
     * @inject
     */
    protected $priorityRepository = null;

    /**
     * salesTrendRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\SalesTrendRepository
     * @inject
     */
    protected $salesTrendRepository = null;

    /**
     * geographicalSectorRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\GeographicalSectorRepository
     * @inject
     */
    protected $geographicalSectorRepository = null;

    /**
     * productSectorRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ProductSectorRepository
     * @inject
     */
    protected $productSectorRepository = null;

    /**
     * performanceRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\PerformanceRepository
     * @inject
     */
    protected $performanceRepository = null;

    /**
     * technicalDevelopmentRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\TechnicalDevelopmentRepository
     * @inject
     */
    protected $technicalDevelopmentRepository = null;

    /**
     * productivityRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\ProductivityRepository
     * @inject
     */
    protected $productivityRepository = null;

    /**
     * costSavingRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\CostSavingRepository
     * @inject
     */
    protected $costSavingRepository = null;

    /**
     * graphRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\GraphRepository
     * @inject
     */
    protected $graphRepository = null;

    /**
     * stepControlRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\StepControlRepository
     * @inject
     */
    protected $stepControlRepository = null;

    /**
     * frontendUserRepository
     *
     * @var \RKW\RkwWepstra\Domain\Repository\FrontendUserRepository
     * @inject
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
        $costSavingList = $wepstraToDelete->getCostSaving();
        if (count($costSavingList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\CostSaving $costSaving */
            foreach ($costSavingList as $costSaving) {
                $this->costSavingRepository->removeHard($costSaving);
            }
        }

        // 1.2 geographicalSector
        $geographicalSectorList = $wepstraToDelete->getGeographicalSector();
        if (count($geographicalSectorList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector */
            foreach ($geographicalSectorList as $geographicalSector) {
                $this->geographicalSectorRepository->removeHard($geographicalSector);
            }
        }

        // 1.3 jobFamily
        $jobFamilyList = $wepstraToDelete->getJobFamily()->toArray();
        if (count($jobFamilyList)) {
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
        $participantList = $wepstraToDelete->getParticipants();
        if (count($participantList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\Participant $participant */
            foreach ($participantList as $participant) {
                $this->participantRepository->removeHard($participant);
            }
        }

        // 1.6 performance
        $performanceList = $wepstraToDelete->getPerformance();

        if (count($performanceList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\Performance $performance */
            foreach ($performanceList as $performance) {
                $this->performanceRepository->removeHard($performance);
            }
        }

        // 1.7 productivity
        $productivityList = $wepstraToDelete->getProductivity();
        if (count($productivityList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\Productivity $productivity */
            foreach ($productivityList as $productivity) {
                $this->productivityRepository->removeHard($productivity);
            }
        }

        // 1.8 productSector
        $productSectorList = $wepstraToDelete->getProductSector();
        if (count($productivityList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\ProductSector $productSector */
            foreach ($productSectorList as $productSector) {
                $this->productSectorRepository->removeHard($productSector);
            }
        }

        // 1.9 reasonWhy
        $reasonWhyList = $wepstraToDelete->getReasonWhy();
        if (count($reasonWhyList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy */
            foreach ($reasonWhyList as $reasonWhy) {
                $this->reasonWhyRepository->removeHard($reasonWhy);
            }
        }

        // 1.10 salesTrend
        $salesTrendList = $wepstraToDelete->getSalesTrend();
        if (count($salesTrendList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend */
            foreach ($salesTrendList as $salesTrend) {
                $this->salesTrendRepository->removeHard($salesTrend);
            }
        }

        // 1.11 technicalDevelopment
        $technicalDevelopmentList = $wepstraToDelete->getTechnicalDevelopment();
        if (count($technicalDevelopmentList)) {
            /** @var \RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment */
            foreach ($technicalDevelopmentList as $technicalDevelopment) {
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