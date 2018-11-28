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
 * SalesTrendRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SalesTrendRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * delete from DB (really!)
     *
     * @param \RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend
     * @return void
     */
    public function removeHard(\RKW\RkwWepstra\Domain\Model\SalesTrend $salesTrend)
    {

        $GLOBALS['TYPO3_DB']->sql_query("
			DELETE FROM tx_rkwwepstra_domain_model_salestrend
			WHERE uid = " . intval($salesTrend->getUid()) . "
		");
    }

}