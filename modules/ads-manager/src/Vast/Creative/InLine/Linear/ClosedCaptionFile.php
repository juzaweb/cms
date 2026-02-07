<?php
declare(strict_types=1);

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Juzaweb\Modules\AdsManagement\Vast\Creative\InLine\Linear;

/**
 * Optional node that enables closed caption sidecar files associated with the ad media (video or audio)
 * to be provided to the player. Multiple files with different mime-types may be provided to allow the player
 * to select the one it is compatible with.
 *
 * Compatible with VAST starting from version 4.1
 *
 * See section 3.9.4 of VAST specification version 4.1
 *
 * @author Leonardo Matos Rodriguez <leon486@gmail.com>
 */
class ClosedCaptionFile
{
    /**
     * @var \DomElement
     */
    private $domElement;

    /**
     * @param \DomElement $domElement
     */
    public function __construct(\DomElement $domElement)
    {
        $this->domElement = $domElement;
    }

    /**
     * Set file mime type
     *
     * @param string $mime Mime type of the file
     */
    public function setType(string $mime): self
    {
        $this->domElement->setAttribute('type', $mime);

        return $this;
    }

    /**
     * Set file language
     *
     * @param string $languag Language of the file e.g: 'en'
     */
    public function setLanguage(string $language): self
    {
        $this->domElement->setAttribute('language', $language);

        return $this;
    }

    /**
     * Set file URL
     *
     * @param string $url URL of the file
     */
    public function setUrl(string $url): self
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);

        // update CData
        if ($this->domElement->hasChildNodes()) {
            $this->domElement->replaceChild($cdata, $this->domElement->firstChild);
        } // insert CData
        else {
            $this->domElement->appendChild($cdata);
        }
        return $this;
    }
}
