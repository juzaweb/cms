<?php

namespace Juzaweb\CMS\Support;

class GoogleTranslate
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
     * @throws \Exception
     */
    public static function translate($source, $target, $text)
    {
        // Request translation
        $response = self::requestTranslation($source, $target, $text);

        // Clean translation
        $translation = self::getSentencesFromJSON($response);

        return $translation;
    }

    /**
     * Internal function to make the request to the translator service
     *
     * @internal
     *
     * @param string $source
     *            Original language taken from the 'translate' function
     * @param string $target
     *            Target language taken from the ' translate' function
     * @param string $text
     *            Text to translate taken from the 'translate' function
     *
     * @return object[] The response of the translation service in JSON format
     * @throws \Exception
     */
    protected static function requestTranslation($source, $target, $text)
    {
        // Google translate URL
        $url = "https://translate.google.com/translate_a/single"
         . "?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=es-ES"
         . "&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e";

        $fields = array(
            'sl' => urlencode($source),
            'tl' => urlencode($target),
            'q' => urlencode($text)
        );

        if (strlen($fields['q']) >= 5000) {
            throw new \Exception("Maximum number of characters exceeded: 5000");
        }

        // URL-ify the data for the POST
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        rtrim($fields_string, '&');

        // Open connection
        $ch = curl_init();
        //$proxy = '113.160.235.194:4153';
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
    }

    /**
     * Dump of the JSON's response in an array
     *
     * @param string $json
     *            The JSON object returned by the request function
     *
     * @return string A single string with the translation
     */
    protected static function getSentencesFromJSON($json)
    {
        $sentencesArray = json_decode($json, true);
        $sentences = "";

        if (!$sentencesArray) {
            $error = 'Google detected unusual traffic from your computer network, try again later (2 - 48 hours)';
            \Log::error($error);
            \Storage::disk('local')->put('lock-translate.txt', $error);
            return false;
        }

        if (!isset($sentencesArray["sentences"])) {
            return " ";
        }

        foreach ($sentencesArray["sentences"] as $s) {
            $sentences .= isset($s["trans"]) ? $s["trans"] : '';
        }

        return $sentences;
    }
}
