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

namespace Org_Heigl\LinguLab\Entity;

class ProcessTextAdvanced
{
    private $text;

    private $textGenre = '';

    private $languageKey = '';

    private $searchKeyword1 = '';

    private $searchKeyword2 = '';

    private $searchKeyword3 = '';

    private $sectionTypeSettings = null;

    private $backUrl = null;

    private $isPreviewTextGenerated = false;

    private $isWordCloudGenerated = false;

    private $resultKey = null;


    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function setConfigurationId(string $textGenre)
    {
        $this->textGenre = $textGenre;
    }

    public function setLanguageKey(string $languageKey)
    {
        $this->languageKey = $languageKey;
    }

    public function setSearchKeyword1(string $searchKeyword)
    {
        $this->searchKeyword1 = $searchKeyword;
    }

    public function setSearchKeyword2(string $searchKeyword)
    {
        $this->searchKeyword2 = $searchKeyword;
    }

    public function setSearchKeyword3(string $searchKeyword)
    {
        $this->searchKeyword3 = $searchKeyword;
    }

    public function setSectionTypeSetting(SectionType $sectionType)
    {
        $this->sectionTypeSettings = $sectionType;
    }

    public function setBackUrl(BackUrl $backUrl)
    {
        $this->backUrl = $backUrl;
    }

    public function setPreviewTextGenerated(boolean $generated)
    {
        $this->isPreviewTextGenerated = $generated;
    }

    public function setWordCloudGenerated(boolean $generated)
    {
        $this->isWordCloudGenerated = $generated;
    }

    public function setResultKey(int $resultKey)
    {
        $this->resultKey = $resultKey;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function getResultKey() : int
    {
        return $this->resultKey;
    }

    public function getConfigurationId() : string
    {
        return $this->textGenre;
    }

    public function getLanguageKey() : string
    {
        return $this->languageKey;
    }

    public function getSearchKeyword1() : string
    {
        return $this->searchKeyword1;
    }

    public function getSearchKeyword2() : string
    {
        return $this->searchKeyword2;
    }

    public function getSearchKeyword3() : string
    {
        return $this->searchKeyword3;
    }

    public function getSectionTypeSettings() : SectionType
    {
        return $this->sectionTypeSettings;
    }

    public function getBackUrl() : BackUrl
    {
        return $this->backUrl;
    }

    public function isPreviewTextGenerated() : bool
    {
        return $this->isPreviewTextGenerated;
    }

    public function isWordCloudGenerated() : bool
    {
        return $this->isWordCloudGenerated;
    }

    public function hasResultKey() : bool
    {
        return null !== $this->resultKey;
    }

    public function hasBackUrl() : bool
    {
        return null !== $this->backUrl;
    }

    public function hasLanguageKey() : bool
    {
        return '' === $this->languageKey;
    }

    public function hasSearchKeyword1() : bool
    {
        return '' !== $this->searchKeyword1;
    }

    public function hasSearchKeyword2() : bool
    {
        return '' !== $this->searchKeyword2;
    }

    public function hasSearchKeyword3() : bool
    {
        return '' !== $this->searchKeyword3;
    }

    public function hasSectionTypeSettings() : bool
    {
        return null !== $this->sectionTypeSettings;
    }

    public function hasConfigurationId() : bool
    {
        return '' !== $this->textGenre;
    }
}
