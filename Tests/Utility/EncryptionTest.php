<?php
namespace TYPO3\FalWebdav\Tests\Utility;

/*                                                                        *
 * This script belongs to the TYPO3 project.                              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License as published by the Free   *
 * Software Foundation, either version 2 of the License, or (at your      *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        *
 * You should have received a copy of the GNU General Public License      *
 * along with the script.                                                 *
 * If not, see http://www.gnu.org/licenses/gpl.html                       *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Testcase for the WebDAV driver encryption tools
 *
 * @author Andreas Wolf <andreas.wolf@ikt-werk.de>
 * @package TYPO3
 * @subpackage fal_webdav
 */
class EncryptionTest extends \Tx_Phpunit_TestCase {
	/**
	 * @test
	 */
	public function passwordsCanBeEncryptedAndDecrypted() {
		$password = uniqid();

		$encryptedPassword = \TYPO3\FalWebdav\Utility\Encryption::encryptPassword($password);
		$decryptedPassword = \TYPO3\FalWebdav\Utility\Encryption::decryptPassword($encryptedPassword);

		$this->assertEquals($password, $decryptedPassword);
	}

	/**
	 * @test
	 */
	public function encryptedPasswordContainsAlgorithm() {
		$password = uniqid();

		$encryptedPassword = \TYPO3\FalWebdav\Utility\Encryption::encryptPassword($password);

		$this->assertStringStartsWith(
			sprintf('$%s$%s$',
				\TYPO3\FalWebdav\Utility\Encryption::getEncryptionMethod(),
				\TYPO3\FalWebdav\Utility\Encryption::getEncryptionMode()
			),
			$encryptedPassword
		);
	}

	/**
	 * @test
	 */
	public function encryptingEmptyStringReturnsEmptyString() {
		$encryptedPassword = \TYPO3\FalWebdav\Utility\Encryption::encryptPassword('');

		$this->assertEmpty($encryptedPassword);
	}

	/**
	 * @test
	 */
	public function decryptingEmptyStringReturnsEmptyString() {
		$this->assertEquals('', \TYPO3\FalWebdav\Utility\Encryption::decryptPassword(''));
	}
}