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

use RKW\RkwWepstra\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * AbstractController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AbstractController extends ActionController
{
	/**
	 * wepstraRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\WepstraRepository
	 * @inject
	 */
	protected $wepstraRepository;

	/**
	 * participantRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\ParticipantRepository
	 * @inject
	 */
	protected $participantRepository;

	/**
	 * reasonWhyRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\ReasonWhyRepository
	 * @inject
	 */
	protected $reasonWhyRepository;

	/**
	 * jobFamilyRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\JobFamilyRepository
	 * @inject
	 */
	protected $jobFamilyRepository;

	/**
	 * priorityRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\PriorityRepository
	 * @inject
	 */
	protected $priorityRepository;

	/**
	 * salesTrendRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\SalesTrendRepository
	 * @inject
	 */
	protected $salesTrendRepository;

	/**
	 * geographicalSectorRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\GeographicalSectorRepository
	 * @inject
	 */
	protected $geographicalSectorRepository;

	/**
	 * productSectorRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\ProductSectorRepository
	 * @inject
	 */
	protected $productSectorRepository;

	/**
	 * performanceRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\PerformanceRepository
	 * @inject
	 */
	protected $performanceRepository;

	/**
	 * technicalDevelopmentRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\TechnicalDevelopmentRepository
	 * @inject
	 */
	protected $technicalDevelopmentRepository;

	/**
	 * productivityRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\ProductivityRepository
	 * @inject
	 */
	protected $productivityRepository;

	/**
	 * costSavingRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\CostSavingRepository
	 * @inject
	 */
	protected $costSavingRepository;

	/**
	 * graphRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\GraphRepository
	 * @inject
	 */
	protected $graphRepository;


	/**
	 * wepstra
	 *
	 * @var \RKW\RkwWepstra\Domain\Model\Wepstra
	 */
	protected $wepstra;

	/**
	 * Persistence Manager
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * frontendUserRepository
	 *
	 * @var \RKW\RkwWepstra\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $frontendUserRepository;

	/**
	 * jsonHelper
	 *
	 * @var \RKW\RkwWepstra\Helper\Json
	 */
	protected $jsonHelper;

	/**
	 * proofStepHelper
	 *
	 * @var \RKW\RkwWepstra\Helper\VerifyStep
	 */
	protected $verifyStepHelper;

	/**
	 * basicDataHelper
	 *
	 * @var \RKW\RkwWepstra\Helper\BasicData
	 */
	protected $basicDataHelper;

	/**
	 * logged FrontendUser
	 *
	 * @var \RKW\RkwWepstra\Domain\Model\FrontendUser
	 */
	protected $frontendUser;



	/**
	 * Id of logged User
	 *
	 * @return integer
	 */
	protected function getFrontendUserId() {

		// is $GLOBALS set?
		if (
			($GLOBALS['TSFE'])
			&& ($GLOBALS['TSFE']->loginUser)
			&& ($GLOBALS['TSFE']->fe_user->user['uid'])
		) {
			return intval($GLOBALS['TSFE']->fe_user->user['uid']);
		}

		return FALSE;
	}



	/**
	 * Returns current logged in user object
	 *
	 * @return \RKW\RkwWepstra\Domain\Model\FrontendUser|NULL
	 */
	protected function getFrontendUser() {

		/** @var FrontendUserRepository $frontendUserRepository */
		$frontendUserRepository = GeneralUtility::makeInstance(FrontendUserRepository::class);
		$this->frontendUser = $frontendUserRepository->findByIdentifier($this->getFrontendUserId());

		if ($this->frontendUser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            return $this->frontendUser;
        }

		return NULL;
	}
}