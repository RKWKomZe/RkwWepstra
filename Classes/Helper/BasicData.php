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

use RKW\RkwWepstra\Domain\Model\GeographicalSector;
use RKW\RkwWepstra\Domain\Model\Performance;
use RKW\RkwWepstra\Domain\Model\Productivity;
use RKW\RkwWepstra\Domain\Model\ProductSector;
use RKW\RkwWepstra\Domain\Model\ReasonWhy;
use RKW\RkwWepstra\Domain\Model\SalesTrend;
use RKW\RkwWepstra\Domain\Model\Wepstra;
use RKW\RkwWepstra\Domain\Repository\GeographicalSectorRepository;
use RKW\RkwWepstra\Domain\Repository\PerformanceRepository;
use RKW\RkwWepstra\Domain\Repository\ProductivityRepository;
use RKW\RkwWepstra\Domain\Repository\ProductSectorRepository;
use RKW\RkwWepstra\Domain\Repository\ReasonWhyRepository;
use RKW\RkwWepstra\Domain\Repository\SalesTrendRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
     * @var Wepstra $wepstra
     * @return void
     */
    public function createAllBasicData(Wepstra $wepstra)
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
     * @var Wepstra $wepstra
     * @return void
     */
    public function reasonWhy(Wepstra $wepstra)
    {
        $reasonWhyRepository = GeneralUtility::makeInstance(ReasonWhyRepository::class);

        $reasonWhy = GeneralUtility::makeInstance(ReasonWhy::class);
        $reasonWhy->setDescription(LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.reason_why1', 'rkw_wepstra'));
        $reasonWhyRepository->add($reasonWhy);
        $wepstra->addReasonWhy($reasonWhy);

        $reasonWhy = GeneralUtility::makeInstance(ReasonWhy::class);
        $reasonWhy->setDescription(LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.reason_why2', 'rkw_wepstra'));
        $reasonWhyRepository->add($reasonWhy);
        $wepstra->addReasonWhy($reasonWhy);

        $reasonWhy = GeneralUtility::makeInstance(ReasonWhy::class);
        $reasonWhy->setDescription(LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.reason_why3', 'rkw_wepstra'));
        $reasonWhyRepository->add($reasonWhy);
        $wepstra->addReasonWhy($reasonWhy);

    }


    /**
     * geographicalSector
     *
     * @var Wepstra $wepstra
     * @return void
     */
    public function geographicalSector(Wepstra $wepstra)
    {
        $geographicalSectorRepository = GeneralUtility::makeInstance(GeographicalSectorRepository::class);

        $geographicalSector = GeneralUtility::makeInstance(GeographicalSector::class);
        $geographicalSector->setTitle(LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.regions_germany', 'rkw_wepstra'));
        $geographicalSectorRepository->add($geographicalSector);
        $wepstra->addGeographicalSector($geographicalSector);

        $geographicalSector = GeneralUtility::makeInstance(GeographicalSector::class);
        $geographicalSector->setTitle(LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.europe', 'rkw_wepstra'));
        $geographicalSectorRepository->add($geographicalSector);
        $wepstra->addGeographicalSector($geographicalSector);

        $geographicalSector = GeneralUtility::makeInstance(GeographicalSector::class);
        $geographicalSector->setTitle(LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.worldwide', 'rkw_wepstra'));
        $geographicalSectorRepository->add($geographicalSector);
        $wepstra->addGeographicalSector($geographicalSector);
    }


    /**
     * productSector
     *
     * @var Wepstra $wepstra
     * @return void
     */
    public function productSector(Wepstra $wepstra)
    {
        $productSectorRepository = GeneralUtility::makeInstance(ProductSectorRepository::class);

        $productSector = GeneralUtility::makeInstance(ProductSector::class);
        $productSector->setTitle(LocalizationUtility::translate('tx_rkwwepstra_helper_basicdata.product_sector_1', 'rkw_wepstra'));
        $productSectorRepository->add($productSector);
        $wepstra->addProductSector($productSector);
    }


    /**
     * salesTrend
     *
     * @var Wepstra $wepstra
     * @return void
     */
    public function salesTrend(Wepstra $wepstra)
    {
        $salesTrendRepository = GeneralUtility::makeInstance(SalesTrendRepository::class);

        $salesTrend = GeneralUtility::makeInstance(SalesTrend::class);
        $salesTrendRepository->add($salesTrend);
        $wepstra->addSalesTrend($salesTrend);
    }


    /**
     * performance
     *
     * @var Wepstra $wepstra
     * @return void
     */
    public function performance(Wepstra $wepstra)
    {
        $performanceRepository = GeneralUtility::makeInstance(PerformanceRepository::class);

        $performance = GeneralUtility::makeInstance(Performance::class);
        $performance->setType(0);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

        $performance = GeneralUtility::makeInstance(Performance::class);
        $performance->setType(1);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

        $performance = GeneralUtility::makeInstance(Performance::class);
        $performance->setType(2);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

        $performance = GeneralUtility::makeInstance(Performance::class);
        $performance->setType(3);
        $performanceRepository->add($performance);
        $wepstra->addPerformance($performance);

    }


    /**
     * technicalDevelopment
     *
     * @var Wepstra $wepstra
     * @return void
     */
    public function technicalDevelopment(Wepstra $wepstra)
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
     * @var Wepstra $wepstra
     * @return void
     */
    public function productivity(Wepstra $wepstra)
    {

        $productivityRepository = GeneralUtility::makeInstance(ProductivityRepository::class);

        $productivity = GeneralUtility::makeInstance(Productivity::class);
        $productivity->setValue(0);
        $productivityRepository->add($productivity);
        $wepstra->addProductivity($productivity);
    }


    /**
     * costSaving
     *
     * @var Wepstra $wepstra
     * @return void
     */
    public function costSaving(Wepstra $wepstra)
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