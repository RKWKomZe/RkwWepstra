<?php

namespace RKW\RkwWepstra\Domain\Model;

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
 * FrontendUser
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FrontendUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{
    /**
     * @var integer
     */
    protected $crdate;

    /**
     * @var integer
     */
    protected $disable = 1;

    /**
     * @var integer
     */
    protected $endtime;

    /**
     * lastlogin
     *
     * @var integer
     */
    protected $lastlogin = 0;

    /**
     * @var boolean
     */
    protected $txRkwwepstraIsAnonymous = false;

    /**
     * @var string
     */
    protected $txRkwwepstraLanguageKey = '';

    /**
     * Sets the crdate value
     *
     * @param integer $crdate
     * @api
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the crdate value
     *
     * @return integer
     * @api
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Sets the disable value
     *
     * @param integer $disable
     * @return void
     *
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
    }

    /**
     * Returns the disable value
     *
     * @return integer
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Sets the endtime value
     *
     * @param integer $endtime
     * @api
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }

    /**
     * Returns the endtime value
     *
     * @return integer
     * @api
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Returns the txRkwWepstraIsAnonymous
     *
     * @return boolean $txRkwWepstraIsAnonymous
     */
    public function getTxRkwWepstraIsAnonymous()
    {
        return $this->txRkwwepstraIsAnonymous;
    }

    /**
     * Sets the txRkwWepstraIsAnonymous
     *
     * @param boolean $txRkwWepstraIsAnonymous
     * @return void
     */
    public function setTxRkwWepstraIsAnonymous($txRkwWepstraIsAnonymous)
    {
        $this->txRkwwepstraIsAnonymous = $txRkwWepstraIsAnonymous;
    }

    /**
     * Sets the txRkwwepstraLanguageKey value
     *
     * @param string $languageKey
     * @return void
     *
     */
    public function setTxRkwwepstraLanguageKey($languageKey)
    {
        $this->txRkwwepstraLanguageKey = $languageKey;
    }

    /**
     * Returns the txRkwwepstraLanguageKey value
     *
     * @return string
     *
     */
    public function getTxRkwwepstraLanguageKey()
    {
        return $this->txRkwwepstraLanguageKey;
    }

    /**
     * Returns the lastlogin
     *
     * @return integer $lastlogin
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * Sets the username value
     * ! Important: We need to lowercase it !
     *
     * @param string $username
     * @return void
     * @api
     */
    public function setUsername($username)
    {
        $this->username = strtolower($username);
    }

}