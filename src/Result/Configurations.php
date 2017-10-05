<?php
/**
 * Copyright (c)2013-2013 Andreas Heigl/wdv Gesellschaft für Medien &
 * Kommunikation mbH & Co. OHG
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal
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
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  wdvCompass
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2013-2017 Andreas Heigl/wdv Gesellschaft für Medien &
 *            Kommunikation mbH & Co. OHG
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     04.10.17
 */

namespace Org_Heigl\LinguLab\Result;

class Configurations
{
    private $configs;

    public function __construct()
    {
        $this->configs = [];
    }

    public function addConfiguration(Configuration $configuration)
    {
        $this->configs[] = $configuration;
    }

    public function getConfigurations(): array
    {
        return $this->configs;
    }

    public function hasConfiguration(string $id): bool
    {
        foreach ($this->configs as $config) {
            if ($config->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function getConfiguration(string $id): Configuration
    {
        foreach ($this->configs as $config) {
            if ($config->getId() == $id) {
                return $config;
            }
        }

        throw new \UnexpectedValueException(sprintf(
            'No Configuration "%1" found',
            $id
        ));
    }
}
