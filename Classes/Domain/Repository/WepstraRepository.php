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
 * WepstraRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class WepstraRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * initializeObject
     *
     * @return void
     */
    public function initializeObject()
    {

        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(false);
    }

    /**
     * findByFrontendUserAlsoDisabled
     * Handels only Wepstra projects of FrontendUser (for choose in header). Not a feature of anonymousUser!
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
     * @return array
     */
    public function findByFrontendUserAlsoDisabled(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser)
    {

        $query = $this->createQuery();
        // setIgnoreEnableFields for hidden records
        //	$query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        $query->setOrderings(array("lastUpdate" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        $allWepstraProjectsOfUser = $query
            ->matching(
                $query->logicalAnd(
                    $query->equals('frontendUser', $frontendUser),
                    $query->logicalOr(
                        $query->equals('disabled', 0),
                        $query->equals('disabled', 1)
                    )
                )
            )
            ->execute();

        return $allWepstraProjectsOfUser;
        //===
    }


    /**
     * findByFrontendUserAlsoDisabled
     * Handels only Wepstra projects of FrontendUser (for choose in header). Not a feature of anonymousUser!
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
     * @return array
     */
    public function findByAnonymousUserAlsoDisabled(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser)
    {

        $query = $this->createQuery();
        // setIgnoreEnableFields for hidden records
        //	$query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        $query->setOrderings(array("lastUpdate" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        $allWepstraProjectsOfUser = $query
            ->matching(
                $query->logicalAnd(
                    $query->equals('anonymousUser', $frontendUser),
                    $query->logicalOr(
                        $query->equals('disabled', 0),
                        $query->equals('disabled', 1)
                    )
                )
            )
            ->execute();

        return $allWepstraProjectsOfUser;
        //===
    }


    /**
     * findEnabledByFrontendUser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
     * @return array
     */
    public function findOneEnabledByFrontendUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser)
    {
        $query = $this->createQuery();

        $wepstra = $query
            ->matching(
                $query->logicalAnd(
                    $query->equals('frontendUser', $frontendUser),
                    $query->equals('disabled', 0)
                )
            )
            ->execute()->getFirst();

        return $wepstra;
        //===
    }


    /**
     * findOneEnabledByAnonymousUser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
     * @return array
     */
    public function findOneEnabledByAnonymousUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser)
    {
        $query = $this->createQuery();

        $wepstra = $query
            ->matching(
                $query->logicalAnd(
                    $query->equals('anonymousUser', $frontendUser),
                    $query->equals('disabled', 0)
                )
            )
            ->execute()->getFirst();

        return $wepstra;
        //===
    }


    /*
     * findAbandoned
     *
     * Find anonymous wepstras where no existing user (normal or anonymous) is set
     *
     * @param integer $cleanupTimestamp
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findAbandoned($cleanupTimestamp)
    {

        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                $query->logicalAnd(
                    $query->lessThanOrEqual('crdate', $cleanupTimestamp),
                    $query->greaterThan('crdate', 0)
                ),
                $query->logicalAnd(
                    $query->equals('anonymousUser.uid', null),
                    $query->equals('frontendUser.uid', null)
                )
            )
        );

        return $query->execute();
        //===

    }


    /**
     * delete from DB (really!)
     *
     * @param \RKW\RkwWepstra\Domain\Model\Wepstra $wepstra
     * @return void
     */
    public function removeHard(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstra)
    {

        $GLOBALS['TYPO3_DB']->sql_query("
			DELETE FROM tx_rkwwepstra_domain_model_wepstra
			WHERE uid = " . intval($wepstra->getUid()) . "
		");
    }

}