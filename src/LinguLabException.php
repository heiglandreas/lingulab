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
    public static function authenticationFailed(string $message, int $error = 101): self
    {
        return new self(sprintf(
            'Authentication failed: %s',
            $message
        ), $error);
    }

    public static function authenticationSessionStillOpen(string $message, int $error = 102): self
    {
        return new self(sprintf(
            'There is already an authentication session open. You can not open an ew session until the old one isn\'t closed: %s',
            $message
        ), $error);
    }

    public static function loginLimitExceeded(string $message, int $error = 103): self
    {
        return new self(sprintf(
            'Too many login tries, The login tries limit was reached',
            $message
        ), $error);
    }

    public static function wrongPluginKey(string $message, int $error = 104): self
    {
        return new self(sprintf(
            'The provided key is not valid for this plugin: %s',
            $message
        ), $error);
    }

    public static function authenticationKeyWasExpired(string $message, int $error = 142): self
    {
        return new self(sprintf(
            'Authentication key was expired: %s',
            $message
        ), $error);
    }

    public static function lackOfPermission(string $message, int $error = 143): self
    {
        return new self(sprintf(
            'Lack of permission: %s',
            $message
        ), $error);
    }

    public static function wrongParameter(
        string $message,
        int $error = 240,
        string $detail = 'Empty result key or authentication key'
    ): self
    {
        return new self(sprintf(
            'Wrong Parameter (%s): %s',
            $detail,
            $message
        ), $error);
    }

    public static function wrongResultKey(
        string $message,
        int $error = 241,
        string $detail = 'Could not get results by provided result key'
    ): self
    {
        return new self(sprintf(
            'Wrong result key. (%s): %s',
            $detail,
            $message
        ), $error);
    }

    public static function internalError(string $message, int $error = 300): self
    {
        return new self(sprintf(
            'Internal error: %s',
            $message
        ), $error);
    }

    public static function processingTextLengthError(string $message, int $error = 231): self
    {
        return new self(sprintf(
            'Processing text length error: %s',
            $message
        ), $error);
    }

    public static function gettingConfigurationFileFailed(string $message, int $error = 232): self
    {
        return new self(sprintf(
            'Getting Configuration File failed: %s',
            $message
        ), $error);
    }

    public static function wrongLanguage(string $message, int $error = 233): self
    {
        return new self(sprintf(
            'Wrong Language: %s',
            $message
        ), $error);
    }

    public static function genericError(string $message, int $error): self
    {
        return new self(sprintf(
            'generic error: %s',
            $message
        ), $error);
    }
}
