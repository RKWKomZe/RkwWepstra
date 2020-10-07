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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * DataController
 * This controller only get, set and return some data via ajax
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DataController extends \RKW\RkwWepstra\Controller\AbstractController
{
    /**
     * initializeAction
     * !! for all actions !!
     */
    public function initializeAction()
    {

        // create json request object
        $this->jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        // Initial: check if user is logged in -> otherwise show login form
        // Because issues can happen, if user reload wepstra via cache
        if (!$GLOBALS['TSFE']->fe_user->user) {

            $errorMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_step.invalid_session', 'rkw_wepstra');

            $replacements = array(
                'errorMessage' => $errorMessage,
            );

            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-container',
                $replacements,
                'replace',
                'Step/LoginChoice.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

        // get arguments
        $arguments = $this->request->getArguments();

        if ($arguments['wepstraUid']) {
            $wepstraUid = intval($arguments['wepstraUid']);
            $this->wepstra = $this->wepstraRepository->findByUid($wepstraUid);
        } else {

            $this->jsonHelper->setDialogue('Error 1460537893: Wepstra UID not set', 1);
            print (string)$this->jsonHelper;
            exit();
            //===
        }

        // mark this wepstra as updated
        $this->wepstra->setLastUpdate(time());
        $this->wepstraRepository->update($this->wepstra);

    }


    /**
     * action createparticipant
     *
     * @param \RKW\RkwWepstra\Domain\Model\Participant $newParticipant
     */
    public function createparticipantAction(\RKW\RkwWepstra\Domain\Model\Participant $newParticipant)
    {

        try {

            if ($newParticipant->getUsername()) {

                // add participant
                $this->participantRepository->add($newParticipant);
                $this->wepstra->addParticipant($newParticipant);
                $this->wepstraRepository->update($this->wepstra);

                // make step verified
                $this->wepstra->getStepControl()->setStep0(1);
                $this->wepstraRepository->update($this->wepstra);

                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array(
                    'wepstra' => $this->wepstra,
                );

                $this->jsonHelper->setHtml(
                    'participants-list',
                    $replacements,
                    'replace',
                    'Ajax/List/Step0/Participants.html'
                );

                // remove text from add-field
                $this->jsonHelper->setJavaScript('jQuery(\'#main-section\').find(\'.add-text\').val(\'\');');

            } else {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );
            }

            print (string)$this->jsonHelper;
            exit();
            //===


        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }


    }


    /**
     * updateparticipantAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\Participant $participant
     */
    public function updateparticipantAction(\RKW\RkwWepstra\Domain\Model\Participant $participant)
    {

        try {

            $this->participantRepository->update($participant);
            $this->wepstraRepository->update($this->wepstra);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'participant-list',
                $replacements,
                'replace',
                'Ajax/List/Step0/Participants.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action deleteparticipant
     *
     * @param \RKW\RkwWepstra\Domain\Model\Participant $participant
     */
    public function deleteparticipantAction(\RKW\RkwWepstra\Domain\Model\Participant $participant)
    {

        try {
            $this->wepstra->removeParticipant($participant);
            $this->participantRepository->remove($participant);

            // step control entry if there is no more participant in project
            if ($this->wepstra->getParticipants()->count() < 1) {
                $this->wepstra->getStepControl()->setStep0(0);
                $this->wepstraRepository->update($this->wepstra);
            }

            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'participants-list',
                $replacements,
                'replace',
                'Ajax/List/Step0/Participants.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===


        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action createreasonwhy
     *
     * @param \RKW\RkwWepstra\Domain\Model\ReasonWhy $newReasonWhy
     */
    public function createreasonwhyAction(\RKW\RkwWepstra\Domain\Model\ReasonWhy $newReasonWhy)
    {

        try {

            if ($newReasonWhy->getDescription()) {

                $this->reasonWhyRepository->add($newReasonWhy);
                $this->wepstra->addReasonWhy($newReasonWhy);

                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array(
                    'wepstra' => $this->wepstra,
                );

                $this->jsonHelper->setHtml(
                    'reasonwhy-list',
                    $replacements,
                    'replace',
                    'Ajax/List/Step0/ReasonWhy.html'
                );

                // remove text from add-field
                $this->jsonHelper->setJavaScript('jQuery(\'#main-section\').find(\'.add-text\').val(\'\');');

            } else {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );
            }

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * updatereasonwhyAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy
     */
    public function updatereasonwhyAction(\RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy)
    {

        try {

            $this->reasonWhyRepository->update($reasonWhy);
            $this->wepstraRepository->update($this->wepstra);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'reasonwhy-list',
                $replacements,
                'replace',
                'Ajax/List/Step0/ReasonWhy.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action deletereasonwhy
     *
     * @param \RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy
     */
    public function deletereasonwhyAction(\RKW\RkwWepstra\Domain\Model\ReasonWhy $reasonWhy)
    {

        try {

            $this->wepstra->removeReasonWhy($reasonWhy);
            $this->reasonWhyRepository->remove($reasonWhy);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'reasonwhy-list',
                $replacements,
                'replace',
                'Ajax/List/Step0/ReasonWhy.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action createjobfamily
     * var \RKW\RkwWepstra\Domain\Model\JobFamily $newJobFamily
     */
    public function createjobfamilyAction(\RKW\RkwWepstra\Domain\Model\JobFamily $newJobFamily)
    {

        try {

            if ($newJobFamily->getTitle()) {

                $this->jobFamilyRepository->add($newJobFamily);
                $this->wepstra->addJobFamily($newJobFamily);

                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array(
                    'wepstra' => $this->wepstra,
                );

                $this->jsonHelper->setHtml(
                    'job-family-list',
                    $replacements,
                    'replace',
                    'Ajax/List/Step1/JobFamily.html'
                );

                // remove text from add-field
                $this->jsonHelper->setJavaScript('jQuery(\'#main-section\').find(\'.add-text\').val(\'\');');

            } else {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );
            }

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action deletejobfamily
     * var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     */
    public function deletejobfamilyAction(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {

        try {

            $this->wepstra->removeJobFamily($jobFamily);
            $this->jobFamilyRepository->remove($jobFamily);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'job-family-list',
                $replacements,
                'replace',
                'Ajax/List/Step1/JobFamily.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action savepriority
     *
     * @var \RKW\RkwWepstra\Domain\Model\Priority $priority
     */
    public function savepriorityAction(\RKW\RkwWepstra\Domain\Model\Priority $priority)
    {

        try {

            /*

            In dieser Funktion ist ein kleiner Workaround notwendig, da es zu problemen bei neu angelegten Instanzen vom
            Objekttyp "priority" kommen kann. Da wir nach dem setzen eines Wertes kein neues HTML ausgeben (welche die
            UID der neuen Instanz beinhalten würde), müssen wir testen, ob der Nutzer (ohne die Seite zwischenzeitlich
            neu zu laden), eventuell weitere Einstellungen dieser Priority-Instanz vornimmt.

            Dieser Abgleich ist durch die unique-Schlüsselkombination ParticipantUid / JobFamilyUid gewährleistet, die
            so immer nur einmal vorkommen kann.

            */

            // 1. add if not persist yet
            $priorityFromDb = $this->priorityRepository->findByParticipantAndJobFamily($priority->getParticipant(), $priority->getJobFamily());

            if ($priorityFromDb instanceof \RKW\RkwWepstra\Domain\Model\Priority && !$priority->getUid()) {
                // workaround because of identity problems
                $priorityFromDb->setValue($priority->getValue());
                $this->priorityRepository->update($priorityFromDb);

            } elseif ($priority instanceof \RKW\RkwWepstra\Domain\Model\Priority && $priority->getUid()) {

                $this->priorityRepository->update($priority);

            } else {
                $this->priorityRepository->add($priority);
            }
            $this->persistenceManager->persistAll();

            // 2. new rating for current jobFamily
            // get all priorities of family and build average
            /** @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $priorityList */
            $priorityList = $this->priorityRepository->findByJobFamily($priority->getJobFamily());
            $fullValue = 0;

            /** @var \RKW\RkwWepstra\Domain\Model\Priority $priorityFromList */
            foreach ($priorityList as $priorityFromList) {
                $fullValue += $priorityFromList->getValue();
            }

            $priority->getJobFamily()->setPriorityAverage($fullValue);

            /*
            // catch division by zero (PHP Alert / Warning)
            if (!count($priorityList)) {
                $priority->getJobFamily()->setPriorityAverage($priority->getValue());
            } else {
                $priority->getJobFamily()->setPriorityAverage(round($fullValue / count($priorityList), 1));
            }
            */

            // 3. persist all
            $this->jobFamilyRepository->update($priority->getJobFamily());
            $this->persistenceManager->persistAll();


            // 4. get priorities of users in relation to jobfamily (if already exists)
            $participantList = $this->wepstra->getParticipants();
            $jobFamilyList = $this->wepstra->getJobFamily();

            $priorityList = null;
            foreach ($participantList as $participant) {
                foreach ($jobFamilyList as $jobFamily) {

                    $priority = $this->priorityRepository->findByParticipantAndJobFamily($participant, $jobFamily);
                    if ($priority) {
                        $priorityList[$participant->getUid()][$jobFamily->getUid()][] = $priority;
                    }

                }
            }


            /* Dieses replacement darf nicht stattfinden. Sorgt nach der Verarbeitung für Chaos im Frontend und hat
               genau genommen auch keinen Nutzen, da per JS bereits alles "live" geregelt wird
            */
            /*
            // 5. create view
            $replacements = array (
                'wepstra' => $this->wepstra,
                'priorityList' => $priorityList,
            );

            // load content
            $this->jsonHelper->setHtml(
                'participant-ratings',
                $replacements,
                'replace',
                'Ajax/List/Step2/Ratings.html'
            );
            */


            // print muss drinbleiben, damit Ajax-Api den Schritt im Frontend fertig verarbeitet (auch wenn nichts geschieht)
            print (string)$this->jsonHelper;
            exit();
            //===


        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

    }


    /**
     * action selectfamily
     * var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     */
    public function selectjobfamilyAction(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {

        try {

            // workaround: Every checkbox in fluid gets a hidden pendant with a fallback value, if checkbox is
            // not clicked. Because we have the checkbox again and again with the same name in several forms,
            // there is an issue. Because of this I added a hidden-field for every checkbox. This works fine,
            // except in case of the first checkbox. Here is the delivered value "NULL" and this thrown an error.
            // Only for this (the first checkbox), we manually set the value to 0, if "NULL" is delivered
            // (The first checkbox get an additional, system-generated hidden field with value NULL)
            if ($jobFamily->getSelected() == null) {
                $jobFamily->setSelected(0);
            }

            $this->jobFamilyRepository->update($jobFamily);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'select-job-family',
                $replacements,
                'replace',
                'Ajax/List/Step2/SelectJobFamily.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action updateplanninghorizon
     *
     * @param \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @ignorevalidation $wepstra
     */
    public function updateplanninghorizonAction(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        try {

            // At this point we always have a string formatted TargetDate! We always have to convert this JS driven input!
            $wepstra->setTargetDate(strtotime($wepstra->getTargetDate()));

            $this->wepstraRepository->update($wepstra);
            $this->persistenceManager->persistAll();

            $this->jsonHelper->setStatus(1);

            /*
            $replacements = array (
                'wepstra' => $this->wepstra,
            );


            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step3.html'
            );
            */

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

    }


    /**
     * updatesalestrendAction
     * var \RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend
     * @ignorevalidation $salesTrend
     */
    public function updatesalestrendAction(\RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend)
    {

        try {

            if (!is_numeric($salesTrend->getCurrentSales()) || !is_numeric($salesTrend->getFutureSales()) || !is_numeric($salesTrend->getPercentage())) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            if ($salesTrend->getPercentage() < 0 || $salesTrend->getPercentage() > 100) {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_helper_verifystep.salestrend_percentage', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            $this->salesTrendRepository->update($salesTrend);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub2',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub2Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * creategeographicalsector
     * \RKW\RkwWepstra\Domain\Model\GeographicalSector $newGeographicalSector
     * @ignorevalidation $newGeographicalSector
     */
    public function creategeographicalsectorAction(\RKW\RkwWepstra\Domain\Model\GeographicalSector $newGeographicalSector)
    {

        try {

            if (!is_numeric($newGeographicalSector->getCurrentSales()) || !is_numeric($newGeographicalSector->getFutureSales()) || !is_numeric($newGeographicalSector->getPercentage())) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            if ($newGeographicalSector->getTitle()) {

                $this->geographicalSectorRepository->add($newGeographicalSector);
                $this->wepstra->addGeographicalSector($newGeographicalSector);

                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array(
                    'wepstra' => $this->wepstra,
                );

                $this->jsonHelper->setHtml(
                    'fake-table-step3sub2',
                    $replacements,
                    'replace',
                    'Ajax/List/Step3/Step3sub2Table.html'
                );

                // remove text from add-field
                $this->jsonHelper->setJavaScript('jQuery(\'#main-section\').find(\'.add-text\').val(\'\');');

            } else {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );
            }

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * updategeographicalsector
     *
     * @param \RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector
     * @ignorevalidation $geographicalSector
     */
    public function updategeographicalsectorAction(\RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector)
    {

        try {

            // proof numbers
            if (!is_numeric($geographicalSector->getCurrentSales()) || !is_numeric($geographicalSector->getFutureSales()) || !is_numeric($geographicalSector->getPercentage())) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            // proof title
            if (!$geographicalSector->getTitle()) {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );

                print (string)$this->jsonHelper;
                exit();
                //===
            }

            $this->geographicalSectorRepository->update($geographicalSector);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub2',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub2Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }


    }


    /**
     * deletegeographicalsector
     * \RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector
     */
    public function deletegeographicalsectorAction(\RKW\RkwWepstra\Domain\Model\GeographicalSector $geographicalSector)
    {

        try {

            $this->wepstra->removeGeographicalSector($geographicalSector);
            $this->geographicalSectorRepository->remove($geographicalSector);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub2',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub2Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * createproductsectorAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\ProductSector $newProductSector
     * @ignorevalidation $newProductSector
     */
    public function createproductsectorAction(\RKW\RkwWepstra\Domain\Model\ProductSector $newProductSector)
    {

        try {

            if (!is_numeric($newProductSector->getCurrentSales()) || !is_numeric($newProductSector->getFutureSales()) || !is_numeric($newProductSector->getPercentage())) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            if ($newProductSector->getTitle()) {

                $this->productSectorRepository->add($newProductSector);
                $this->wepstra->addProductSector($newProductSector);

                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array(
                    'wepstra' => $this->wepstra,
                );

                $this->jsonHelper->setHtml(
                    'fake-table-step3sub2',
                    $replacements,
                    'replace',
                    'Ajax/List/Step3/Step3sub2Table.html'
                );

                // remove text from add-field
                $this->jsonHelper->setJavaScript('jQuery(\'#main-section\').find(\'.add-text\').val(\'\');');

            } else {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );
            }

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * updateproductsector
     *
     * @param \RKW\RkwWepstra\Domain\Model\ProductSector $productSector
     * @ignorevalidation $productSector
     */
    public function updateproductsectorAction(\RKW\RkwWepstra\Domain\Model\ProductSector $productSector)
    {

        try {

            if (!is_numeric($productSector->getCurrentSales()) || !is_numeric($productSector->getFutureSales()) || !is_numeric($productSector->getPercentage())) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            // proof title
            if (!$productSector->getTitle()) {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );

                print (string)$this->jsonHelper;
                exit();
                //===
            }

            $this->productSectorRepository->update($productSector);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub2',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub2Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * deleteproductsector
     *
     * @param \RKW\RkwWepstra\Domain\Model\ProductSector $productSector
     */
    public function deleteproductsectorAction(\RKW\RkwWepstra\Domain\Model\ProductSector $productSector)
    {

        try {

            $this->wepstra->removeProductSector($productSector);
            $this->productSectorRepository->remove($productSector);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub2',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub2Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * updateperformance
     *
     * @param \RKW\RkwWepstra\Domain\Model\Performance $performance
     */
    public function updateperformanceAction(\RKW\RkwWepstra\Domain\Model\Performance $performance)
    {

        try {

            if ($performance->getValue() == null) {
                $performance->setValue(0);
            }

            $this->performanceRepository->update($performance);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub3',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub3Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }



    /**
     * updateknowledge
     *
     * @param \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     */
    /*	public function updateknowledgeAction(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra) {

            try {

                if ($wepstra->getKnowledge() == NULL) {
                    $wepstra->setKnowledge(0);
                }

                $this->wepstraRepository->update($wepstra);
                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array (
                    'wepstra' => $this->wepstra
                );

                $this->jsonHelper->setHtml(
                    'fake-table-step3sub3',
                    $replacements,
                    'replace',
                    'Ajax/List/Step3/Step3sub3Table.html'
                );

                print (string) $this->jsonHelper;
                exit();
                //===

            } catch (\Exception $e ) {

                $this->jsonHelper->setDialogue(
                    sprintf (
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                        ),
                        $e->getMessage()
                    ), 99
                );

                print (string) $this->jsonHelper;
                exit();
                //===
            }

        }
    */


    /**
     * createtechdevAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $newTechnicalDevelopment
     */
    public function createtechdevAction(\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $newTechnicalDevelopment)
    {

        try {

            if ($newTechnicalDevelopment->getDescription()) {

                $this->technicalDevelopmentRepository->add($newTechnicalDevelopment);
                $this->wepstra->addTechnicalDevelopment($newTechnicalDevelopment);

                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array(
                    'wepstra' => $this->wepstra,
                );

                $this->jsonHelper->setHtml(
                    'fake-table-step3sub3',
                    $replacements,
                    'replace',
                    'Ajax/List/Step3/Step3sub3Table.html'
                );

                // remove text from add-field
                $this->jsonHelper->setJavaScript('jQuery(\'#main-section\').find(\'.add-text\').val(\'\');');

            } else {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );
            }

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

    }


    /**
     * updatetechdevAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment
     */
    public function updatetechdevAction(\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment)
    {

        try {

            // check textfield
            if (!$technicalDevelopment->getDescription()) {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );

                print (string)$this->jsonHelper;
                exit();
                //===
            }

            $this->technicalDevelopmentRepository->update($technicalDevelopment);
            $this->persistenceManager->persistAll();

            /*
            // get new list
            $replacements = array (
                'wepstra' => $this->wepstra
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub3',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub3Table.html'
            );
            */

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * deletetechdev
     *
     * @param \RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment
     */
    public function deletetechdevAction(\RKW\RkwWepstra\Domain\Model\TechnicalDevelopment $technicalDevelopment)
    {

        try {

            $this->wepstra->removeTechnicalDevelopment($technicalDevelopment);
            $this->technicalDevelopmentRepository->remove($technicalDevelopment);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub3',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub3Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * updateproductivityAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\Productivity $productivity
     */
    public function updateproductivityAction(\RKW\RkwWepstra\Domain\Model\Productivity $productivity)
    {

        try {

            if (!is_numeric($productivity->getValue()) || $productivity->getValue() > 100 || $productivity->getValue() < 0) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            $this->productivityRepository->update($productivity);
            $this->persistenceManager->persistAll();

            /*
            // get new list
            $replacements = array (
                'wepstra' => $this->wepstra
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub4',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub4Table.html'
            );
            */

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * createcostsavingAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\CostSaving $newCostSaving
     */
    public function createcostsavingAction(\RKW\RkwWepstra\Domain\Model\CostSaving $newCostSaving)
    {

        try {

            if (!is_numeric($newCostSaving->getValue())) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            if ($newCostSaving->getTitle()) {

                $this->costSavingRepository->add($newCostSaving);
                $this->wepstra->addCostSaving($newCostSaving);

                $this->persistenceManager->persistAll();

                // get new list
                $replacements = array(
                    'wepstra' => $this->wepstra,
                );

                $this->jsonHelper->setHtml(
                    'fake-table-step3sub4',
                    $replacements,
                    'replace',
                    'Ajax/List/Step3/Step3sub4Table.html'
                );

                // remove text from add-field
                $this->jsonHelper->setJavaScript('jQuery(\'#main-section\').find(\'.add-text\').val(\'\');');

            } else {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );
            }

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }


    }


    /**
     * deletecostsaving
     *
     * @param \RKW\RkwWepstra\Domain\Model\CostSaving $costSaving
     */
    public function deletecostsavingAction(\RKW\RkwWepstra\Domain\Model\CostSaving $costSaving)
    {

        try {

            $this->wepstra->removeCostSaving($costSaving);
            $this->costSavingRepository->remove($costSaving);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub4',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub4Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * updatecostsavingAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\CostSaving $costSaving
     */
    public function updatecostsavingAction(\RKW\RkwWepstra\Domain\Model\CostSaving $costSaving)
    {

        try {

            // proof number
            if (!is_numeric($costSaving->getValue())) {
                $this->jsonHelper->setStatus(99);
                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_data.error_numeric', 'rkw_wepstra')
                    , 1
                );
                print (string)$this->jsonHelper;
                exit();
                //===
            }

            // proof title
            if (!$costSaving->getTitle()) {

                $this->jsonHelper->setDialogue(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.message_enter_text', 'rkw_wepstra'
                    ), 1
                );

                print (string)$this->jsonHelper;
                exit();
                //===
            }


            $this->costSavingRepository->update($costSaving);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'fake-table-step3sub4',
                $replacements,
                'replace',
                'Ajax/List/Step3/Step3sub4Table.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action savestrategyAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     */
    public function savestrategyAction(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {

        try {

            $this->jobFamilyRepository->update($jobFamily);

            // 5. persist all
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $this->jsonHelper->setHtml(
                'strategy-list',
                $replacements,
                'replace',
                'Ajax/List/Step4/Strategy.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

    }


    /**
     * updategraphAction
     *
     * @param \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     */
    public function updategraphAction(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {

        try {

            $this->jobFamilyRepository->update($jobFamily);
            $this->persistenceManager->persistAll();

            // get new list
            $replacements = array(
                'wepstra' => $this->wepstra,
            );

            $arguments = $this->request->getArguments();
            $template = 'Ajax/List/Step5/BubbleGraph' . intval($arguments['graph']) . '.html';

            $this->jsonHelper->setHtml(
                'bubble-graphs',
                $replacements,
                'replace',
                $template
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /*
    * updatetasksAction
    *
     * @param \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
    */
    public function updatetasksAction(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {
        try {

            $this->jobFamilyRepository->update($jobFamily);
            $this->persistenceManager->persistAll();

            /*
            // get new list
            $replacements = array (
                'wepstra' => $this->wepstra
            );

            $this->jsonHelper->setHtml(
                'job-family-list',
                $replacements,
                'replace',
                'Ajax/List/Step6/Tasks.html'
            );
            */
            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }
}