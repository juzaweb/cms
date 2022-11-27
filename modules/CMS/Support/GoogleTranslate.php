<?php

namespace Juzaweb\CMS\Support;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Juzaweb\CMS\Contracts\GoogleTranslate as GoogleTranslateContract;

class GoogleTranslate implements GoogleTranslateContract
{
    /**
     * Retrieves the translation of a text
     *
     * @param string $source
     *            Original language of the text on notation xx. For example: es, en, it, fr...
     * @param string $target
     *            Language to which you want to translate the text in format xx. For example: es, en, it, fr...
     * @param string $text
     *            Text that you want to translate
     *
     * @return string a simple string with the translation of the text in the target language
     * @throws Exception|GuzzleException
     */
    public function translate(string $source, string $target, string $text): string
    {
        // Request translation
        $response = self::requestTranslation($source, $target, $text);

        return self::getSentencesFromJSON($response);
    }

    /**
     * Internal function to make the request to the translator service
     *
     * @param string $source
     *            Original language taken from the 'translate' function
     * @param string $target
     *            Target language taken from the ' translate' function
     * @param string $text
     *            Text to translate taken from the 'translate' function
     *
     * @return string The response of the translation service in JSON format
     * @throws Exception|GuzzleException
     *@internal
     *
     */
    protected function requestTranslation(string $source, string $target, string $text): string
    {
        if (strlen($text) >= 5000) {
            throw new Exception("Maximum number of characters exceeded: 5000");
        }

        $url = "https://translate.google.com/translate_a/single"
         . "?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=es-ES"
         . "&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e";

        $client = $this->getClient()->post(
            $url,
            [
                'form_params' => [
                    'sl' => $source,
                    'tl' => $target,
                    'q' => $text
                ]
            ]
        );

        return $client->getBody()->getContents();
    }

    /**
     * Dump of the JSON's response in an array
     *
     * @param string $json
     *            The JSON object returned by the request function
     *
     * @return string A single string with the translation
     * @throws Exception
     */
    protected function getSentencesFromJSON(string $json): string
    {
        $sentencesArray = json_decode($json, true);
        $sentences = "";

        if (!$sentencesArray) {
            throw new Exception(
                'Google detected unusual traffic from your computer network,'
                    .' try again later (2 - 48 hours)'
            );
            \Storage::disk('local')->put('lock-translate.txt', $error);
        }

        if (!isset($sentencesArray["sentences"])) {
            return " ";
        }

        foreach ($sentencesArray["sentences"] as $s) {
            $sentences .= $s["trans"] ?? '';
        }

        return $sentences;
    }

    protected function getClient(): Client
    {
        return new Client(
            [
                'headers' => [
                    'User-Agent' => 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1',
                ],
                'curl' => [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => 'UTF-8',
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ]
            ]
        );
    }
}
