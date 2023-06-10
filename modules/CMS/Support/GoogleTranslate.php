<?php

namespace Juzaweb\CMS\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Juzaweb\CMS\Contracts\GoogleTranslate as GoogleTranslateContract;
use Juzaweb\CMS\Exceptions\GoogleTranslateException;

class GoogleTranslate implements GoogleTranslateContract
{
    protected Client $client;

    protected string|array|null $proxy = null;

    public function __construct(protected Filesystem $storage)
    {
    }

    public function withProxy(string|array $proxy): static
    {
        $this->proxy = $proxy;

        return $this;
    }

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
     * @throws GoogleTranslateException
     * @throws GuzzleException
     */
    public function translate(string $source, string $target, string $text): string
    {
        if ($lock = $this->getDisk()->get('lock-translate.txt')) {
            if ($lock < now()->subHours(2)->format('Y-m-d H:i:s')) {
                throw new GoogleTranslateException(
                    'Translate locked: Google detected unusual traffic from your computer network,'
                    .' try again later (2 - 48 hours)'
                );
            }

            $this->getDisk()->delete('lock-translate.txt');
        }

        $response = $this->requestTranslation($source, $target, $text);

        return $this->getSentencesFromJSON($response);
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
     * @throws GoogleTranslateException|GuzzleException
     *@internal
     *
     */
    protected function requestTranslation(string $source, string $target, string $text): string
    {
        if (strlen($text) >= 5000) {
            throw new GoogleTranslateException("Maximum number of characters exceeded: 5000");
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
     * @throws GoogleTranslateException
     */
    protected function getSentencesFromJSON(string $json): string
    {
        $sentencesArray = json_decode($json, true);
        $sentences = "";

        if (!$sentencesArray) {
            $this->getDisk()->put('lock-translate.txt', now()->format('Y-m-d H:i:s'));

            throw new GoogleTranslateException(
                'Google detected unusual traffic from your computer network,'
                    .' try again later (2 - 48 hours)'
            );
        }

        if (!isset($sentencesArray["sentences"])) {
            return " ";
        }

        foreach ($sentencesArray["sentences"] as $s) {
            $sentences .= $s["trans"] ?? '';
        }

        return $sentences;
    }

    protected function getDisk(): \Illuminate\Contracts\Filesystem\Filesystem
    {
        return $this->storage->disk('local');
    }

    protected function getClient(): Client
    {
        if (isset($this->client)) {
            return $this->client;
        }

        $options = [
            'headers' => [
                'User-Agent' => 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1',
            ],
            'curl' => [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => 'UTF-8',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]
        ];

        if ($this->proxy) {
            $options['proxy'] = $this->proxy;
        }

        return $this->client = new Client($options);
    }
}
