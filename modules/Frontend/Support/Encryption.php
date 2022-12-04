<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Frontend\Support;

use Exception;

class Encryption
{
    /**
     * @link http://php.net/manual/en/function.openssl-get-cipher-methods.php Available methods.
     * @var string Cipher method. Recommended AES-128-CBC, AES-192-CBC, AES-256-CBC
     */
    protected string $encryptMethod = 'AES-256-CBC';

    /**
     * Decrypt string.
     *
     * @param string $encryptedString The encrypted string that is base64 encode.
     * @param string $key The key.
     * @return mixed Return original string value. Return null for failure get salt, iv.
     */
    public function decrypt(string $encryptedString, string $key): mixed
    {
        $json = json_decode(base64_decode($encryptedString), true);

        try {
            $salt = hex2bin($json["salt"]);
            $iv = hex2bin($json["iv"]);
        } catch (Exception $e) {
            return null;
        }

        $cipherText = base64_decode($json['ciphertext']);

        $iterations = intval(abs($json['iterations']));
        if ($iterations <= 0) {
            $iterations = 999;
        }
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));
        unset($iterations, $json, $salt);

        $decrypted = openssl_decrypt($cipherText, $this->encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        unset($cipherText, $hashKey, $iv);

        return $decrypted;
    }// decrypt


    /**
     * Encrypt string.
     *
     * @param string $string The original string to be encrypt.
     * @param string $key The key.
     * @return string Return encrypted string.
     */
    public function encrypt(string $string, string $key): string
    {
        $ivLength = openssl_cipher_iv_length($this->encryptMethod);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $salt = openssl_random_pseudo_bytes(256);
        $iterations = 999;
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));
        $encryptedString = openssl_encrypt(
            $string,
            $this->encryptMethod,
            hex2bin($hashKey),
            OPENSSL_RAW_DATA,
            $iv
        );
        $encryptedString = base64_encode($encryptedString);
        unset($hashKey);

        $output = [
            'ciphertext' => $encryptedString,
            'iv' => bin2hex($iv),
            'salt' => bin2hex($salt),
            'iterations' => $iterations
        ];
        unset($encryptedString, $iterations, $iv, $ivLength, $salt);

        return base64_encode(json_encode($output));
    }

    /**
     * Get encrypt method length number (128, 192, 256).
     *
     * @return integer.
     */
    protected function encryptMethodLength(): int
    {
        $number = (int) filter_var($this->encryptMethod, FILTER_SANITIZE_NUMBER_INT);

        return intval(abs($number));
    }

    /**
     * Set encryption method.
     *
     * @link http://php.net/manual/en/function.openssl-get-cipher-methods.php Available methods.
     * @param string $cipherMethod
     */
    public function setCipherMethod(string $cipherMethod): void
    {
        $this->encryptMethod = $cipherMethod;
    }
}
