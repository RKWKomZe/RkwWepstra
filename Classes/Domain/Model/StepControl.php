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
 * StepControl
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StepControl extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * step0
     *
     * @var integer
     */
    protected $step0 = 0;

    /**
     * step1
     *
     * @var integer
     */
    protected $step1 = 0;

    /**
     * step2sub2
     *
     * @var integer
     */
    protected $step2 = 0;

    /**
     * step2sub3
     *
     * @var integer
     */
    protected $step2sub2 = 0;

    /**
     * step3
     *
     * @var integer
     */
    protected $step3 = 0;

    /**
     * step3sub2
     *
     * @var integer
     */
    protected $step3sub2 = 0;

    /**
     * step3sub3
     *
     * @var integer
     */
    protected $step3sub3 = 0;

    /**
     * step3sub4
     *
     * @var integer
     */
    protected $step3sub4 = 0;

    /**
     * step4
     *
     * @var integer
     */
    protected $step4 = 0;

    /**
     * step5
     *
     * @var integer
     */
    protected $step5 = 0;

    /**
     * step5sub2
     *
     * @var integer
     */
    protected $step5sub2 = 0;

    /**
     * step5sub3
     *
     * @var integer
     */
    protected $step5sub3 = 0;

    /**
     * step5sub4
     *
     * @var integer
     */
    protected $step5sub4 = 0;

    /**
     * step5sub5
     *
     * @var integer
     */
    protected $step5sub5 = 0;

    /**
     * step6
     *
     * @var integer
     */
    protected $step6 = 0;

    /**
     * Returns the step0
     *
     * @return string $step0
     */
    public function getStep0()
    {
        return $this->step0;
    }

    /**
     * Sets the step0
     *
     * @param string $step0
     * @return void
     */
    public function setStep0($step0)
    {
        $this->step0 = $step0;
    }

    /**
     * Returns the step1
     *
     * @return string $step1
     */
    public function getStep1()
    {
        return $this->step1;
    }

    /**
     * Sets the step1
     *
     * @param string $step1
     * @return void
     */
    public function setStep1($step1)
    {
        $this->step1 = $step1;
    }

    /**
     * Returns the step2
     *
     * @return string $step2
     */
    public function getStep2()
    {
        return $this->step2;
    }

    /**
     * Sets the step2
     *
     * @param string $step2
     * @return void
     */
    public function setStep2($step2)
    {
        $this->step2 = $step2;
    }

    /**
     * Returns the step2sub2
     *
     * @return string $step2sub2
     */
    public function getStep2sub2()
    {
        return $this->step2sub2;
    }

    /**
     * Sets the step2sub2
     *
     * @param string $step2sub2
     * @return void
     */
    public function setStep2sub2($step2sub2)
    {
        $this->step2sub2 = $step2sub2;
    }

    /**
     * Returns the step3
     *
     * @return string $step3
     */
    public function getStep3()
    {
        return $this->step3;
    }

    /**
     * Sets the step3
     *
     * @param string $step3
     * @return void
     */
    public function setStep3($step3)
    {
        $this->step3 = $step3;
    }

    /**
     * Returns the step3sub2
     *
     * @return string $step3sub2
     */
    public function getStep3sub2()
    {
        return $this->step3sub2;
    }

    /**
     * Sets the step3sub2
     *
     * @param string $step3sub2
     * @return void
     */
    public function setStep3sub2($step3sub2)
    {
        $this->step3sub2 = $step3sub2;
    }

    /**
     * Returns the step3sub3
     *
     * @return string $step3sub3
     */
    public function getStep3sub3()
    {
        return $this->step3sub3;
    }

    /**
     * Sets the step3sub3
     *
     * @param string $step3sub3
     * @return void
     */
    public function setStep3sub3($step3sub3)
    {
        $this->step3sub3 = $step3sub3;
    }

    /**
     * Returns the step3sub4
     *
     * @return string $step3sub4
     */
    public function getStep3sub4()
    {
        return $this->step3sub4;
    }

    /**
     * Sets the step3sub4
     *
     * @param string $step3sub4
     * @return void
     */
    public function setStep3sub4($step3sub4)
    {
        $this->step3sub4 = $step3sub4;
    }

    /**
     * Returns the step4
     *
     * @return string $step4
     */
    public function getStep4()
    {
        return $this->step4;
    }

    /**
     * Sets the step4
     *
     * @param string $step4
     * @return void
     */
    public function setStep4($step4)
    {
        $this->step4 = $step4;
    }

    /**
     * Returns the step5
     *
     * @return string $step5
     */
    public function getStep5()
    {
        return $this->step5;
    }

    /**
     * Sets the step5
     *
     * @param string $step5
     * @return void
     */
    public function setStep5($step5)
    {
        $this->step5 = $step5;
    }

    /**
     * Returns the step5sub2
     *
     * @return string $step5sub2
     */
    public function getStep5sub2()
    {
        return $this->step5sub2;
    }

    /**
     * Sets the step5sub2
     *
     * @param string $step5sub2
     * @return void
     */
    public function setStep5sub2($step5sub2)
    {
        $this->step5sub2 = $step5sub2;
    }

    /**
     * Returns the step5sub3
     *
     * @return string $step5sub3
     */
    public function getStep5sub3()
    {
        return $this->step5sub3;
    }

    /**
     * Sets the step5sub3
     *
     * @param string $step5sub3
     * @return void
     */
    public function setStep5sub3($step5sub3)
    {
        $this->step5sub3 = $step5sub3;
    }

    /**
     * Returns the step5sub4
     *
     * @return string $step5sub4
     */
    public function getStep5sub4()
    {
        return $this->step5sub4;
    }

    /**
     * Sets the step5sub4
     *
     * @param string $step5sub4
     * @return void
     */
    public function setStep5sub4($step5sub4)
    {
        $this->step5sub4 = $step5sub4;
    }

    /**
     * Returns the step5sub5
     *
     * @return string $step5sub5
     */
    public function getStep5sub5()
    {
        return $this->step5sub5;
    }

    /**
     * Sets the step5sub5
     *
     * @param string $step5sub5
     * @return void
     */
    public function setStep5sub5($step5sub5)
    {
        $this->step5sub5 = $step5sub5;
    }

    /**
     * Returns the step6
     *
     * @return string $step6
     */
    public function getStep6()
    {
        return $this->step6;
    }

    /**
     * Sets the step6
     *
     * @param string $step6
     * @return void
     */
    public function setStep6($step6)
    {
        $this->step6 = $step6;
    }

}