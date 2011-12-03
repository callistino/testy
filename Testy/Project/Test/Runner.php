<?php
/**
 * testy
 *
 * Copyright (c) 2011, Hans-Peter Buniat <hpbuniat@googlemail.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in
 * the documentation and/or other materials provided with the
 * distribution.
 *
 * * Neither the name of Hans-Peter Buniat nor the names of his
 * contributors may be used to endorse or promote products derived
 * from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package Testy
 * @author Hans-Peter Buniat <hpbuniat@googlemail.com>
 * @copyright 2011 Hans-Peter Buniat <hpbuniat@googlemail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * Run the test-command
 *
 * @author Hans-Peter Buniat <hpbuniat@googlemail.com>
 * @copyright 2011 Hans-Peter Buniat <hpbuniat@googlemail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version Release: @package_version@
 * @link https://github.com/hpbuniat/testy
 */
class Testy_Project_Test_Runner {

    /**
     * The command to execute
     *
     * @var string
     */
    protected $_sCommand = '';

    /**
     * All modified files
     *
     * @var array
     */
    protected $_aFiles = array();

    /**
     * The current file
     *
     * @var string
     */
    protected $_sFile = '';

    /**
     * The current project
     *
     * @var Testy_Project
     */
    protected $_oProject;

    /**
     * Is this a repeated execution ?
     *
     * @var boolean
     */
    protected $_bRepeat = false;

    /**
     * The executions return
     *
     * @var string
     */
    protected $_sReturn = '';

    /**
     * Placeholder for a specific file (triggers Executor_One)
     *
     * @var string
     */
    const FILE_PLACEHOLDER = '$file';

    /**
     * Create the runnter
     *
     * @param  Testy_Project $oProject
     * @param  array $aFiles
     * @param  string $sCommand
     */
    public function __construct(Testy_Project $oProject, array $aFiles, $sCommand) {
        $this->_oProject = $oProject;
        $this->_aFiles = $aFiles;
        $this->_sCommand = $sCommand;
    }

    /**
     * Indicate, that this is a repeated execution
     *
     * @return Testy_Project_Test_Runner
     */
    public function repeat() {
        $this->_bRepeat = true;
        return $this;
    }

    /**
     * Execute the runnter
     *
     * @return Testy_Project_Test_Runner
     */
    public function run() {
        $bSingle = $this->_executeSingle();
        foreach ($this->_aFiles as $this->_sFile) {
            $this->_execute($this->_getCommand($bSingle));
            if ($bSingle !== true) {
                break;
            }
        }

        return $this;
    }

    /**
     * Get the returned content
     *
     * @return string
     */
    public function get() {
        return $this->_sReturn;
    }

    /**
     * Should the command be executed for each file
     *
     * @return boolean
     */
    protected function _executeSingle() {
        return (strpos($this->_sCommand, self::FILE_PLACEHOLDER) !== false and $this->_bRepeat !== true);
    }

    /**
     * Enrich the command with placeholders
     *
     * @return string
     */
    protected function _getCommand($bSingle = false) {
        $aReplace = array(
            self::FILE_PLACEHOLDER => (($bSingle !== true) ? '' : $this->_sFile),
            '$time' => time(),
            '$mtime' => filemtime($this->_sFile),
            '$project' => $this->_oProject->getName()
        );
        return str_replace(array_keys($aReplace), array_values($aReplace), $this->_sCommand);
    }

    /**
     * Execute a command
     *
     * @param  string $sCommand
     *
     * @return boolean
     */
    protected function _execute($sCommand) {
        $oCommand = new Testy_Util_Command();
        $this->_sReturn = $oCommand->execute($sCommand)->get();
        if ($oCommand->isSuccess() !== true) {
            throw new Testy_Project_Test_Exception($this->_sReturn);
        }

        return $oCommand->isSuccess();
    }
}