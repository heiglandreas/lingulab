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
        $object = new \stdClass();

        $object->Text = $this->item->getText();
        if ($this->item->hasResultKey()) {
            $object->ResultKey = $this->item->getResultKey();
        }

        if ($this->item->hasConfigurationId()) {
            $object->ConfigurationId = $this->item->getConfigurationId();
        }

        if (($this->item->hasLanguageKey())) {
            $object->LanguageKey = $this->item->getLanguageKey();
        }

        if (($this->item->hasSearchKeyword1())) {
            $object->SearchKeyword1 = $this->item->getSearchKeyword1();
        }

        if (($this->item->hasSearchKeyword2())) {
            $object->SearchKeyword2 = $this->item->getSearchKeyword2();
        }

        if (($this->item->hasSearchKeyword3())) {
            $object->SearchKeyword3 = $this->item->getSearchKeyword3();
        }

        if (($this->item->hasSectionTypeSettings())) {
            $converter = new SectionTypeToSoap($this->item->getSectionTypeSettings());
            $object->SectionTypeSettings = $converter();
        }

        if (($this->item->hasBackUrl())) {
            $converter = new BackUrlToSoap($this->item->getBackUrl());
            $object->BackUrl = $converter();
        }

        return new \SoapVar($object, SOAP_ENC_OBJECT);
    }
}
