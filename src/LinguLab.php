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
 * @since     12.06.2017
 * @link      http://github.com/heiglandreas/org.heigl.lingulab
 */

namespace Org_Heigl\LinguLab;

use Org_Heigl\LinguLab\Converter\ProcessTextAdvancedToSoap;
use Org_Heigl\LinguLab\Entity\ProcessTextAdvanced;
use stdClass;

class LinguLab
{
    /** @var string */
    private $token = null;

    /** @var \SoapClient */
    private $client;

    public function __construct(string $username, string $password, string $pluginId = null, \SoapClient $client = null)
    {
        $this->client = $client;

        $parameters = [
            'userName' => $username,
            'password' => $password,
        ];

        if (null !== $pluginId) {
            $parameters['plugInId'] = $pluginId;
        }

        $loginresult = $this->client->Login($parameters)->LoginResult;

        $this->handleResponseErrorCode($loginresult);

        if (isset($loginresult->AuthenticationKey)) {
            $this->token = $loginresult->AuthenticationKey;
        }
    }

    public function getLanguages()
    {
        $parameters = [
            'authenticationKey' => $this->token,
        ];

        $result = $this->client->GetLanguages($parameters);

        $this->handleResponseErrorCode($result->GetLanguagesResult);

        return $result->GetLanguagesResult;
    }

    public function getConfigurations(string $language)
    {
        $parameters = [
            'authenticationKey' => $this->token,
            'languageKey' => $language,
        ];

        $result = $this->client->GetConfigurations($parameters);

        $this->handleResponseErrorCode($result->GetConfigurationsResult);

        return $result->GetConfigurationsResult;

    }

    public function processTextAdvanced(ProcessTextAdvancedToSoap $text) : stdClass
    {
        $parameters = [
            'inputData' => $text(),
            'authenticationKey' => $this->token,
        ];

        $result = $this->client->ProcessTextAdv($parameters);

        $this->handleResponseErrorCode($result->ProcessTextAdvResult);

        return $result->ProcessTextAdvResult;
    }

    public function processText(ProcessTextAdvancedToSoap $text) : stdClass
    {
        $parameters = [
            'inputData' => $text(),
            'authenticationKey' => $this->token,
        ];

        $result = $this->client->ProcessText($parameters);

        $this->handleResponseErrorCode($result->ProcessTextResult);

        return $result->ProcessTextResult;
    }

    /**
     * @param stdClass $response
     *
     * @throws \Org_Heigl\LinguLab\LinguLabException
     * @return void
     */
    private function handleResponseErrorCode(stdClass $response)
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
