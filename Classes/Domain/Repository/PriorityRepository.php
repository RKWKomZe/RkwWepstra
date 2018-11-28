<?php

namespace RKW\RkwWepstra\Domain\Repository;
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
 * PriorityRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PriorityRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * findByParticipantAndJobFamily
     *
     * @param integer $participantUid
     * @param integer $jobFamilyUid
     * @return \RKW\RkwWepstra\Domain\Model\Priority | NULL
     */
    public function findByParticipantAndJobFamily($participantUid, $jobFamilyUid)
    {

        $query = $this->createQuery();
        $priority = $query
            ->matching(
                $query->logicalAnd(
                    $query->equals('participant', $participantUid),
                    $query->equals('jobFamily', $jobFamilyUid)
                )
            )
            ->execute()
            ->getFirst();

        return $priority;
        //===
    }

    /**
     * findByJobFamilyForCronjob
     *
     * @param \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily
     * @return array
     */
    public function findByJobFamilyForCronjob(\RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily)
    {

        $query = $this->createQuery();

        $query->statement('
            SELECT *
            FROM tx_rkwwepstra_domain_model_priority
            WHERE job_family = ' . intval($jobFamily->getUid()) . '
        ');

        return $query->execute();
        //===
    }

    /**
     * delete from DB (really!)
     *
     * @param \RKW\RkwWepstra\Domain\Model\Priority $priority
     * @return void
     */
    public function removeHard(\RKW\RkwWepstra\Domain\Model\Priority $priority)
    {

        $GLOBALS['TYPO3_DB']->sql_query("
			DELETE FROM tx_rkwwepstra_domain_model_priority
			WHERE uid = " . intval($priority->getUid()) . "
		");

    }
}