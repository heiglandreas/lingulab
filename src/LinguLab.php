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
use Org_Heigl\LinguLab\Result\Configuration;
use Org_Heigl\LinguLab\Result\Configurations;
use Org_Heigl\LinguLab\Result\Language;
use Org_Heigl\LinguLab\Result\Languages;
use Org_Heigl\LinguLab\Result\ProcessTextAdvanced as ProcessTextAdvancedResult;
use Org_Heigl\LinguLab\Result\ProcessText as ProcessTextResult;
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

    public function getLanguages() : Languages
    {
        $parameters = [
            'authenticationKey' => $this->token,
        ];

        $result = $this->client->GetLanguages($parameters);

        $this->handleResponseErrorCode($result->GetLanguagesResult);

        $languages = new Languages();
        foreach ($result->GetLanguagesResult->Languages as $language) {
            $languages->addLanguage(new Language(
                filter_var($language->LanguageKey, FILTER_SANITIZE_STRING),
                filter_var($language->Name, FILTER_SANITIZE_STRING)
            ));
        }
        return $languages;
    }

    public function getConfigurations(Language $language): Configurations
    {
        $parameters = [
            'authenticationKey' => $this->token,
            'languageKey' => $language->getId(),
        ];

        $result = $this->client->GetConfigurations($parameters);

        $this->handleResponseErrorCode($result->GetConfigurationsResult);

        $configs = new Configurations();
        foreach ($result->GetConfigurationsResult->Configurations as $config) {
            $configs->addConfiguration(new Configuration(
                filter_var($config->Id, FILTER_VALIDATE_INT),
                filter_var($config->Name, FILTER_SANITIZE_STRING),
                filter_var($config->Group, FILTER_SANITIZE_STRING),
                filter_var($config->IsKeywordSupported, FILTER_VALIDATE_BOOLEAN)
            ));
        }

        return $configs;

    }

    public function processTextAdvanced(ProcessTextAdvancedToSoap $text): ProcessTextAdvancedResult
    {
        $parameters = [
            'inputData' => $text(),
            'authenticationKey' => $this->token,
        ];

        $result = $this->client->ProcessTextAdv($parameters);

        $this->handleResponseErrorCode($result->ProcessTextAdvResult);

        return new ProcessTextAdvancedResult(
            $result->ProcessTextAdvResult->ResultId,
            $result->ProcessTextAdvResult->Measure,
            $result->ProcessTextAdvResult->LinkOnResultPage,
            $result->ProcessTextAdvResult->MeasureStarsHtml
        );
    }

    public function processText(ProcessTextAdvancedToSoap $text): ProcessTextResult
    {
        $parameters = [
            'inputData' => $text(),
            'authenticationKey' => $this->token,
        ];

        $result = $this->client->ProcessText($parameters);

        $this->handleResponseErrorCode($result->ProcessTextResult);

        return new ProcessTextResult(
            $result->ProcessTextResult->ResultId,
            $result->ProcessTextResult->Measure,
            $result->ProcessTextResult->LinkOnResultPage,
            $result->ProcessTextResult->MeasureStarsHtml
        );    }

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
            case 131:
            case 141:
                throw LinguLabException::authenticationFailed($response->ErrorMessage, $response->ErrorCode);
            case 102:
                throw LinguLabException::authenticationSessionStillOpen($response->ErrorMessage);
            case 103:
                throw LinguLabException::loginLimitExceeded($response->ErrorMessage);
            case 104:
                throw LinguLabException::wrongPluginKey($response->ErrorMessage);
            case 132:
            case 142:
                throw LinguLabException::authenticationKeyWasExpired($response->ErrorMessage, $response->ErrorCode);
            case 133:
            case 143:
                throw LinguLabException::lackOfPermission($response->ErrorMessage, $response->ErrorCode);
            case 230:
                throw LinguLabException::wrongParameter($response->ErrorMessage, 230, 'Some fields in input data are missed, detailed information should be provided in error message');
            case 231:
                throw LinguLabException::processingTextLengthError($response->ErrorMessage);
            case 232:
                throw LinguLabException::gettingConfigurationFileFailed($response->ErrorMessage);
            case 233:
                throw LinguLabException::wrongLanguage($response->ErrorMessage);
            case 240:
                throw LinguLabException::wrongParameter($response->ErrorMessage);
            case 241:
                throw LinguLabException::wrongResultKey($response->ErrorMessage);
            case 300:
            case 330:
            case 340:
                throw LinguLabException::internalError($response->ErrorMessage, $response->ErrorCode);
            default:
                throw LinguLabException::genericError($response->ErrorMessage, $response->ErrorCode);

        }
    }

}
