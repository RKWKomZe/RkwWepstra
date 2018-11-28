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
 * VerifyStep
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class VerifyStep
{
    /*
     * preparation
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step0(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        if (count($wepstra->getParticipants()) < 1) {

            $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');
            $jsonHelper->setStatus(99);
            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.participant_minimum', 'rkw_wepstra')
                , 1
            );

            print (string)$jsonHelper;
            exit();
            //===
        }

        // mark step as verified
        $wepstra->getStepControl()->setStep0(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * step1
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step1(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step1
        if (count($wepstra->getJobFamily()) < 1) {

            $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');
            $jsonHelper->setStatus(99);
            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.jobfamily_minimum_create', 'rkw_wepstra')
                , 1
            );

            print (string)$jsonHelper;
            exit();
            //===
        }

        // mark step as verified
        $wepstra->getStepControl()->setStep1(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

        // 2. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra, 1);

    }


    /*
     * step2
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step2(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra, 1);

        // 2. proof step2
        $participantList = $wepstra->getParticipants();
        $jobFamilyList = $wepstra->getJobFamily();

        $allParticipantsHaveDefinedPriority = true;

        $i = 0;
        foreach ($participantList as $participant) {

            $j = 0;
            foreach ($jobFamilyList as $jobFamily) {

                $priorityRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\PriorityRepository');
                $priority = $priorityRepository->findByParticipantAndJobFamily($participant, $jobFamily);
                if (!$priority) {
                    $allParticipantsHaveDefinedPriority = false;
                }
                $j++;
            }
            $i++;
        }

        // proof wepstra on minimum one participant
        if (!$allParticipantsHaveDefinedPriority) {

            $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');
            $jsonHelper->setStatus(99);
            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.priorities', 'rkw_wepstra')
                , 1
            );

            print (string)$jsonHelper;
            exit();
            //===
        }

        // mark step as verified
        $wepstra->getStepControl()->setStep2(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * step2sub2
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step2sub2(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra, 1);

        // 2. proof step 2sub2
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');
        $jobFamilyRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\JobFamilyRepository');
        $selectedJobFamilies = $jobFamilyRepository->findSelectedByWepstra($wepstra->getUid());

        // at least 2 job jobfamilies have to be selected
        if (count($selectedJobFamilies) < 1) {

            $jsonHelper->setStatus(99);
            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.jobfamily_minimum', 'rkw_wepstra')
                , 1
            );

            print (string)$jsonHelper;
            exit();
            //===
        }

        // only 8 jobfamilies can selected at once
        if (count($selectedJobFamilies) > 8) {

            $jsonHelper->setStatus(99);
            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.jobfamily_maximum', 'rkw_wepstra')
                , 1
            );

            print (string)$jsonHelper;
            exit();
            //===
        }

        // mark step as verified
        $wepstra->getStepControl()->setStep2sub2(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

    }


    /*
     * step3
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step3(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step3
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        if (!$wepstra->getTargetDate()) {

            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.target_date', 'rkw_wepstra')
                , 1
            );
            print (string)$jsonHelper;
            exit();
            //===
        }

        // mark step as verified
        $wepstra->getStepControl()->setStep3(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * step3sub2
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step3sub2(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step3sub2
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        // check percentage salestrend
        /** @var \RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend */
        foreach ($wepstra->getSalesTrend() as $salesTrend) {

            if ($salesTrend->getPercentage() < 1 || $salesTrend->getPercentage() > 100) {

                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.salestrend_percentage', 'rkw_wepstra')
                    , 1
                );
                print (string)$jsonHelper;
                exit();
                //===
            }
        }

        // check geographical sector (minimum one value should be set)
        if (count($wepstra->getGeographicalSector())) {

            $valueIsSet = true;
            /** @var \RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector */
            foreach ($wepstra->getGeographicalSector() as $geographicalSector) {

                // if salesTrend 1 or 2 is choosen, a sub-step is needed
                if (!$geographicalSector->getCurrentSales() && !$geographicalSector->getFutureSales() && !$geographicalSector->getPercentage()) {
                    $valueIsSet = false;
                }
            }

            if (!$valueIsSet) {
                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.geographical_sector_set_value', 'rkw_wepstra')
                    , 1
                );
                print (string)$jsonHelper;
                exit();
                //===
            }

        }

        // check product sector (minimum one value should be set)
        if (count($wepstra->getProductSector())) {

            $valueIsSet = true;
            $titleIsSet = true;
            /** @var \RKW\RkwWepstra\Domain\Model\ProductSector $productSector */
            foreach ($wepstra->getProductSector() as $productSector) {

                // if salesTrend 1 or 2 is choosen, a sub-step is needed
                if (!$productSector->getCurrentSales() && !$productSector->getFutureSales() && !$productSector->getPercentage()) {
                    $valueIsSet = false;
                }
            }

            if (!$valueIsSet) {
                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.product_sector_set_value', 'rkw_wepstra')
                    , 1
                );
                print (string)$jsonHelper;
                exit();
                //===
            }


        }

        // the percentage values of geographicalSector have to sum up to 100%
        /*
            if(count($wepstra->getGeographicalSector())) {

                $sum = 0;

                foreach ($wepstra->getGeographicalSector() as $geographicalSector) {
                    $sum += (int) $geographicalSector->getValue();
                }

                if ($sum != 100) {
                    $jsonHelper->setDialogue(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.geographicalsector_percentage', 'rkw_wepstra')
                        ,1
                    );
                    print (string) $jsonHelper;
                    exit();
                    //===
                }

            } else {
                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.geographicalsector_create', 'rkw_wepstra')
                    ,1
                );
                print (string) $jsonHelper;
                exit();
                //===
            }
        */

        // the percentage values of productSector have to sum up to 100%
        /*
            if(count($wepstra->getProductSector())) {

                $sum = 0;

                foreach ($wepstra->getProductSector() as $productSector) {
                    $sum += (int) $productSector->getValue();
                }

                if ($sum != 100) {
                    $jsonHelper->setDialogue(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.productsector_percentage', 'rkw_wepstra')
                        ,1
                    );
                    print (string) $jsonHelper;
                    exit();
                    //===
                }

            } else {
                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.productsector_create', 'rkw_wepstra')
                    ,1
                );
                print (string) $jsonHelper;
                exit();
                //===
            }
        */
        // mark step as verified
        $wepstra->getStepControl()->setStep3sub2(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * step3sub3
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step3sub3(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step3sub3
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        $minimumOneIsSelected = false;
        $constantIsSelected = false;
        // 3. check if  minimumm one performance is selected
        /** @var \RKW\RkwWepstra\Domain\Model\Performance $performance */
        foreach ($wepstra->getPerformance() as $performance) {

            if ($performance->getType() == 0 && $performance->getValue() == 1) {
                $constantIsSelected = true;
            }

            if ($performance->getValue()) {
                $minimumOneIsSelected = true;
            }
        }
        if (!$minimumOneIsSelected) {
            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.performance_select_one', 'rkw_wepstra')
                , 1
            );
            print (string)$jsonHelper;
            exit();
            //===
        }


        // check only other fields, of not type = 0 entry is checked
        if (!$constantIsSelected) {

            // check performance of type not 0 (minimum one value should be set)
            $valueIsSet = true;

            /** @var \RKW\RkwWepstra\Domain\Model\ProductSector $productSector */
            foreach ($wepstra->getPerformance() as $performance) {

                // exclude type 0 (stands for "no change" in application)
                // && check only if entry selected (value = 1)
                if ($performance->getType() && $performance->getValue()) {

                    if (!$performance->getDescription() || !$performance->getInfluence() || !$performance->getKnowledge()) {
                        $valueIsSet = false;
                    }

                }

            }


            // throw error if a non-constant value is selected, but no values are set
            if (!$valueIsSet) {
                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.performance_set_value', 'rkw_wepstra')
                    , 1
                );
                print (string)$jsonHelper;
                exit();
                //===
            }
        } else {

            // CATCH IF constant AND further values are checked
            foreach ($wepstra->getPerformance() as $performance) {

                if ($performance->getType() && $performance->getValue() == 1) {
                    $jsonHelper->setDialogue(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.select_constant_or_other', 'rkw_wepstra')
                        , 1
                    );
                    print (string)$jsonHelper;
                    exit();
                    //===
                }
            }


        }

        /*
                // the percentage values of productSector have to sum up to 100%
                if(count($wepstra->getPerformance())) {

                    $sum = 0;

                    foreach ($wepstra->getPerformance() as $performance) {
                        $sum += (int) $performance->getValue();
                    }

                    if ($sum != 100) {
                        $jsonHelper->setDialogue(
                            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.performance_percentage', 'rkw_wepstra')
                            ,1
                        );
                        print (string) $jsonHelper;
                        exit();
                        //===
                    }
                }
        */
        // mark step as verified
        $wepstra->getStepControl()->setStep3sub3(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * step3sub4
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step3sub4(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step3sub4

        // mark step as verified
        $wepstra->getStepControl()->setStep3sub4(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * step4
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step4(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step4

        // mark step as verified
        $wepstra->getStepControl()->setStep4(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * step5
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step5(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step5
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        /** @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
        foreach ($wepstra->getJobFamily() as $jobFamily) {

            // check only selected JobFamilies
            if ($jobFamily->getSelected()) {

                if (is_numeric($jobFamily->getAgeRisk())) {

                    // actually do nothing

                } else {
                    $jsonHelper->setDialogue(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.place_element', 'rkw_wepstra')
                        , 1
                    );
                    print (string)$jsonHelper;
                    exit();
                    //===
                }
            }

        }

        // mark step as verified
        $wepstra->getStepControl()->setStep5(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

    }


    /*
     * step5sub2
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step5sub2(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step5
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        /** @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
        foreach ($wepstra->getJobFamily() as $jobFamily) {

            // check only selected JobFamilies
            if ($jobFamily->getSelected()) {

                if (is_numeric($jobFamily->getCapacityRisk())) {

                    // actually do nothing

                } else {
                    $jsonHelper->setDialogue(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.place_element', 'rkw_wepstra')
                        , 1
                    );
                    print (string)$jsonHelper;
                    exit();
                    //===
                }
            }

        }

        // mark step as verified
        $wepstra->getStepControl()->setStep5sub2(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

    }


    /*
     * step5sub3
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step5sub3(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step5
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        /** @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
        foreach ($wepstra->getJobFamily() as $jobFamily) {

            // check only selected JobFamilies
            if ($jobFamily->getSelected()) {

                if (is_numeric($jobFamily->getCompetenceRisk())) {

                    // actually do nothing

                } else {
                    $jsonHelper->setDialogue(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.place_element', 'rkw_wepstra')
                        , 1
                    );
                    print (string)$jsonHelper;
                    exit();
                    //===
                }
            }

        }

        // mark step as verified
        $wepstra->getStepControl()->setStep5sub3(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

    }


    /*
     * step5sub4
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step5sub4(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step5sub2
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        /** @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
        foreach ($wepstra->getJobFamily() as $jobFamily) {

            // check only selected JobFamilies
            if ($jobFamily->getSelected()) {

                if (is_numeric($jobFamily->getProvisionRisk())) {

                    // actually do nothing

                } else {
                    $jsonHelper->setDialogue(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.place_element', 'rkw_wepstra')
                        , 1
                    );
                    print (string)$jsonHelper;
                    exit();
                    //===
                }
            }
        }

        // mark step as verified
        $wepstra->getStepControl()->setStep5sub4(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

    }


    /*
     * step5sub5
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    public function step5sub5(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        // 1. proof step0 (participants) and step1 (jobFamilies)
        // necessary datasets could be deleted afterwards
        $this->proofSteps($wepstra);

        // 2. proof step5sub5

        // mark step as verified
        $wepstra->getStepControl()->setStep5sub5(1);
        $wepstraRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Repository\\WepstraRepository');
        $wepstraRepository->update($wepstra);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    /*
     * proofSteps
     *
     * Participants and JobFamilies (necessary for whole application)
     *
     * $checkFromStep value 2 is default (check all)
     * -> value 0: Check only step0 (preparation)
     * -> value 1: Check step0 and step 1
     * -> value 2: Check step0, step1 and step2
     *
     * @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @var boolean $checkJobFamily
     * @return RKW\RkwWepstra\Helper\Json|void
     */
    private function proofSteps(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra, $checkFromStep = 2)
    {

        // 1.1 proof step0 (participants)
        // necessary datasets could be deleted afterwards
        if (!$wepstra->getStepControl()->getStep0()) {
            $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');
            $jsonHelper->setStatus(99);
            $jsonHelper->setDialogue(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.step_incomplete', 'rkw_wepstra', array(0))
                , 1
            );

            print (string)$jsonHelper;
            exit();
            //===
        }

        if ($checkFromStep >= 1) {
            // 1.2 proof step1 (jobFamilies)
            // necessary datasets could be deleted afterwards
            if (!$wepstra->getStepControl()->getStep1()) {
                $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');
                $jsonHelper->setStatus(99);
                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.step_incomplete', 'rkw_wepstra', array(1))
                    , 1
                );

                print (string)$jsonHelper;
                exit();
                //===
            }
        }

        if ($checkFromStep >= 2) {
            // 1.2 proof step1 (jobFamilies)
            // necessary datasets could be deleted afterwards
            if (!$wepstra->getStepControl()->getStep2() || !$wepstra->getStepControl()->getStep2sub2()) {
                $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');
                $jsonHelper->setStatus(99);
                $jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.step_incomplete', 'rkw_wepstra', array(2))
                    , 1
                );

                print (string)$jsonHelper;
                exit();
                //===
            }
        }

    }


}