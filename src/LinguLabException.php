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
 * @since     13.06.2017
 * @link      http://github.com/heiglandreas/org.heigl.lingulab
 */

namespace Org_Heigl\LinguLab;

class LinguLabException extends \InvalidArgumentException
{
    public static function authenticationFailed()
    {
        return new self('Authentication failed', 101);
    }

    public static function authenticationSessionStillOpen()
    {
        return new self(
            'There is already an authentication session open. You can not open an ew session until the old one isn\'t closed',
            102
        );
    }

    public static function loginLimitExceeded()
    {
        return new self(
            'Too many login tries, The login tries limit was reached',
            103
        );
    }

    public static function wrongPluginKey()
    {
        return new self(
            'The provided key is not valid for this plugin',
            104
        );
    }

    public static function internalError() : self
    {
        return new self(
            'Internal error',
            300
        );
    }

    public static function genericError(int $error) : self
    {
        return new self(
            'generic error',
            $error
        );
    }
}
