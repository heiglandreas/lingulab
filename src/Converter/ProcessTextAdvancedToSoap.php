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
 * @since     14.06.2017
 * @link      http://github.com/heiglandreas/org.heigl.lingulab
 */

namespace Org_Heigl\LinguLab\Converter;

use Org_Heigl\LinguLab\Entity\ProcessTextAdvanced;

class ProcessTextAdvancedToSoap
{
    private $item;

    public function __construct(ProcessTextAdvanced $item)
    {
        $this->item = $item;
    }

    public function __invoke() : \SoapVar
    {
        $object = [];

        $object[] = new \SoapVar($this->item->getText(), XSD_STRING, null, null, 'ns1:Text');
        if ($this->item->hasResultKey()) {
            $object[] = new \SoapVar($this->item->getResultKey(), XSD_INT, null, null, 'ns1:ResultKey');
        }

        if ($this->item->hasConfigurationId()) {
            $object[] = new \SoapVar($this->item->getConfigurationId(), XSD_STRING, null, null, 'ns1:ConfigurationId');
        }

        if (($this->item->hasLanguageKey())) {
            $object[] = new \SoapVar($this->item->getLanguageKey(), XSD_STRING, null, null, 'ns1:LanguageKey');
        }

        $object[] = new \SoapVar($this->item->getSearchKeyword1(), XSD_STRING, null, null, 'ns1:SearchKeyword1');

        $object[] = new \SoapVar($this->item->getSearchKeyword2(), XSD_STRING, null, null, 'ns1:SearchKeyword1');

        $object[] = new \SoapVar($this->item->getSearchKeyword3(), XSD_STRING, null, null, 'ns1:SearchKeyword2');

        if (($this->item->hasSectionTypeSettings())) {
            $converter = new SectionTypeToSoap($this->item->getSectionTypeSettings());
            $object[] = new \SoapVar($converter(), SOAP_ENC_OBJECT, null, null, 'ns1:SectionTypeSettings');
        }

        if (($this->item->hasBackUrl())) {
            $converter = new BackUrlToSoap($this->item->getBackUrl());
            $object[] = new \SoapVar($converter(), SOAP_ENC_OBJECT, null, null, 'ns1:BackUrl');
        }


        error_log(print_r($object, true));
        return new \SoapVar($object, SOAP_ENC_OBJECT);
    }
}
