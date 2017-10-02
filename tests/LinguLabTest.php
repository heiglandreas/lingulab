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

namespace Org_Heigl\LinguLabTest;

use Org_Heigl\LinguLab\Converter\ProcessTextAdvancedToSoap;
use Org_Heigl\LinguLab\Entity\ProcessTextAdvanced;
use Org_Heigl\LinguLab\LinguLab;
use Org_Heigl\LinguLab\LinguLabFactory;
use PHPUnit\Framework\TestCase;

class LinguLabTest extends TestCase
{
    /** @var  LinguLab */
    private $lingulab;

    public function setup()
    {
        $this->lingulab = LinguLabFactory::create(LINGULAB_USERNAME, LINGULAB_PASSWORD);
    }

    public function testThatLinguLabInstantiates()
    {
        $this->assertInstanceOf(LinguLab::class, $this->lingulab);
        $this->assertAttributeNotEmpty('token', $this->lingulab);
        $this->assertAttributeInstanceof(\SoapClient::class, 'client', $this->lingulab);
    }

    /** @expectedException \Org_Heigl\LinguLab\LinguLabException */
    public function testThatLingulabActuallyDoesSomething()
    {
        $result = $this->lingulab->processTextAdvanced(
            new ProcessTextAdvancedToSoap(
                new ProcessTextAdvanced('Foo')
            )
        );
    }
}
