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
 * Json
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Json extends \RKW\RkwAjax\Encoder\JsonTemplateEncoder
{
    /**
     * @var array message
     */
    protected $dialogue = array();

    /**
     * @var array message
     */
    protected $modal = array();


    /**
     * Sets dialogue
     *
     * @param string $message
     * @param integer $type
     * @return $this
     */
    public function setDialogue($message, $type = 1)
    {

        if (!$message) {
            return $this;
        }
        //===

        $finalType = 99;
        if (in_array(intval($type), array(1, 2, 99))) {
            $finalType = intval($type);
        }

        $this->dialogue['message'] = $message;
        $this->dialogue['type'] = $finalType;

        return $this;
        //===
    }


    /**
     * Sets Modal
     *
     * @param string $message
     * @param integer $type
     * @return $this
     */
    public function setModal($message, $type = 1)
    {

        if (!$message) {
            return $this;
        }
        //===

        $finalType = 99;
        if (in_array(intval($type), array(1, 2, 99))) {
            $finalType = intval($type);
        }

        $this->modal['message'] = $message;
        $this->modal['type'] = $finalType;

        return $this;
        //===
    }


    /**
     * Returns JSON-string
     *
     * @return string
     */
    public function __toString()
    {

        $returnArray = array();
        $returnArray['status'] = $this->status;

        if ($this->dialogue) {
            $returnArray['dialogue'] = $this->dialogue;
        }

        if ($this->modal) {
            $returnArray['modal'] = $this->modal;
        }

        if ($this->message) {
            $returnArray['message'] = $this->message;
        }

        if ($this->data) {
            $returnArray['data'] = $this->data;
        }

        if (
            ($this->javaScript)
            && ($this->javaScript['before'])
        ) {
            $returnArray['javaScriptBefore'] = implode(' ', $this->javaScript['before']);
        }

        if ($this->html) {
            $returnArray['html'] = $this->html;
        }

        if (
            ($this->javaScript)
            && ($this->javaScript['after'])
        ) {
            $returnArray['javaScriptAfter'] = implode(' ', $this->javaScript['after']);
        }

        return json_encode($returnArray);
        //===
    }

}
