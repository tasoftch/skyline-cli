<?php
/**
 * BSD 3-Clause License
 *
 * Copyright (c) 2020, TASoft Applications
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 *  Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 *  Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

namespace Skyline\CLI\Service;


use Skyline\Kernel\Service\Error\AbstractErrorHandlerService;
use Throwable;

class ConsoleErrorHandler extends AbstractErrorHandlerService
{
    private $enabled = false;

    /**
     * ConsoleErrorHandler constructor.
     * @param bool $enabled
     */
    public function __construct(bool $enabled)
    {
        $this->enabled = $enabled;
    }


    public function handleError(string $message, int $code, $file, $line, $ctx): bool
    {
        if($this->enabled) {
            $hdr = "\033[";
            switch ( self::detectErrorLevel($code) ) {
                case self::NOTICE_ERROR_LEVEL:      $hdr .= "0;37mNOTICE    : "; break;
                case self::WARNING_ERROR_LEVEL:     $hdr .= "0;33mWARNING   : "; break;
                case self::DEPRECATED_ERROR_LEVEL:  $hdr .= "1;30mDEPRECATED: "; break;
                default:
                                                    $hdr .= "0;31mERROR     : ";
            }

            fprintf(STDERR, "$hdr%s\033[0m\n            => \033[0;32m%s:\033[0;34m%d\033[m\n", $message, $file, $line);
        }
        return false;
    }

    public function handleException(Throwable $throwable): bool
    {
        if($this->enabled) {

        }
        return false;
    }
}