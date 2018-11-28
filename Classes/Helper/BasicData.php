<?php

namespace RKW\RkwWepstra\Helper;
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
 * BasicData
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BasicData
{
    /**
     * createAllBasicData
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function createAllBasicData(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // Step0
        if (count($wepstra->getReasonWhy()) < 1) {
            $this->reasonWhy($wepstra);
        }

        // Step3sub2
        if (count($wepstra->getSalesTrend()) < 1) {
            $this->salesTrend($wepstra);
        }

        /* ! Sollen nicht mehr gesetzt werden laut #2189
        if (count($wepstra->getGeographicalSector()) < 1) {
            $this->geographicalSector($wepstra);
        }
        if (count($wepstra->getProductSector()) < 1) {
            $this->productSector($wepstra);
        }
        */

        // Step3sub3
        if (count($wepstra->getPerformance()) < 1) {
            $this->performance($wepstra);
        }
        if (count($wepstra->getTechnicalDevelopment()) < 1) {
            $this->technicalDevelopment($wepstra);
        }

        // Step3sub4
        if (count($wepstra->getProductivity()) < 1) {
            $this->productivity($wepstra);
        }
        if (count($wepstra->getCostSaving()) < 1) {
            $this->costSaving($wepstra);
        }

    }


    /**
     * reasonWhy
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function reasonWhy(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {
        $reasonWhyRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\ReasonWhyRepository');

        $reasonWhy = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\ReasonWhy');
        $reasonWhy->setDescription(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.reason_why1', 'rkw_wepstra'));
        $reasonWhyRepository->add($reasonWhy);
        $wepstra->addReasonWhy($reasonWhy);

        $reasonWhy = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\ReasonWhy');
        $reasonWhy->setDescription(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.reason_why2', 'rkw_wepstra'));
        $reasonWhyRepository->add($reasonWhy);
        $wepstra->addReasonWhy($reasonWhy);

        $reasonWhy = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\ReasonWhy');
        $reasonWhy->setDescription(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.reason_why3', 'rkw_wepstra'));
        $reasonWhyRepository->add($reasonWhy);
        $wepstra->addReasonWhy($reasonWhy);

    }


    /**
     * geographicalSector
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function geographicalSector(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        $geographicalSectorRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\GeographicalSectorRepository');

        $geographicalSector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\GeographicalSector');
        $geographicalSector->setTitle(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.regions_germany', 'rkw_wepstra'));
        $geographicalSectorRepository->add($geographicalSector);
        $wepstra->addGeographicalSector($geographicalSector);

        $geographicalSector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\GeographicalSector');
        $geographicalSector->setTitle(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.europe', 'rkw_wepstra'));
        $geographicalSectorRepository->add($geographicalSector);
        $wepstra->addGeographicalSector($geographicalSector);

        $geographicalSector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\GeographicalSector');
        $geographicalSector->setTitle(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.worldwide', 'rkw_wepstra'));
        $geographicalSectorRepository->add($geographicalSector);
        $wepstra->addGeographicalSector($geographicalSector);
    }


    /**
     * productSector
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function productSector(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        $productSectorRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\ProductSectorRepository');

        $productSector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\ProductSector');
        $productSector->setTitle(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.product_sector_1', 'rkw_wepstra'));
        $productSectorRepository->add($productSector);
        $wepstra->addProductSector($productSector);
    }


    /**
     * salesTrend
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function salesTrend(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        $salesTrendRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\SalesTrendRepository');

        $salesTrend = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\SalesTrend');
        $salesTrendRepository->add($salesTrend);
        $wepstra->addSalesTrend($salesTrend);
    }


    /**
     * performance
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function performance(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        $performanceRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\PerformanceRepository');

        $performance = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\Performance');
        $performance->setType(0);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

        $performance = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\Performance');
        $performance->setType(1);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

        $performance = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\Performance');
        $performance->setType(2);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

        $performance = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\Performance');
        $performance->setType(3);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

    }


    /**
     * technicalDevelopment
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function technicalDevelopment(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        /*
            $technicalDevelopmentRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\TechnicalDevelopmentRepository');

            $techDev = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\TechnicalDevelopment');
            $techDev->setValue(1);
            $technicalDevelopmentRepository->add($techDev);
            $wepstra->addTechnicalDevelopment($techDev);
        */
    }


    /**
     * productivity
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function productivity(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        $productivityRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\ProductivityRepository');

        $productivity = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\Productivity');
        $productivity->setValue(0);
        $productivityRepository->add($productivity);
        $wepstra->addProductivity($productivity);
    }


    /**
     * costSaving
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function costSaving(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        /*
        $costSavingRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\CostSavingRepository');

        $costSaving = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\CostSaving');
        $costSaving->setValue(100);
        $costSaving->setTitle(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.area1', 'rkw_wepstra'));
        $costSavingRepository->add($costSaving);
        $wepstra->addCostSaving($costSaving);
        */
    }

}