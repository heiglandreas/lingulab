<?php
/**
 * Copyright (c) Andreas Heigl<andreas@heigl.org>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright Andreas Heigl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT-License
 * @since     19.09.2017
 * @link      http://github.com/heiglandreas/org.heigl.lingulab
 */

namespace Org_Heigl\LinguLab\Handler;

use SoapClient;

abstract class DefaultHandler
{
    private $soapClient;

    protected $method = '';

    public function __construct(SoapClient $client)
    {
        $this->soapClient = $client;
    }

    protected function send(array $payload) : stdClass
    {
        $result = $this->soapClient->{$this->method}($payload);
        $this->handleResponseErrorCode($result);

    }

    abstract public function __invoke(array $payload);

    private function handleResponseErrorCode(stClass $response)
    {
        if (0 === $response->ErrorCode) {
            return;
        }

        switch ($response->ErrorCode) {
            case 101:
                throw LinguLabException::authenticationFailed();
            case 102:
                throw LinguLabException::authenticationSessionStillOpen();
            case 103:
                throw LinguLabException::loginLimitExceeded();
            case 104:
                throw LinguLabException::wrongPluginKey();
            case 300:
                throw LinguLabException::internalError();
            default:
                throw LinguLabException::genericError($response->ErrorCode);

        }
    }
}
