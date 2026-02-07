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

class MediaFile
{
    public const DELIVERY_PROGRESSIVE = 'progressive';
    public const DELIVERY_STREAMING = 'streaming';

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
     * @return MediaFile
     */
    public function setProgressiveDelivery(): self
    {
        $this->setDelivery(self::DELIVERY_PROGRESSIVE);

        return $this;
    }

    /**
     * @return MediaFile
     */
    public function setStreamingDelivery(): self
    {
        $this->setDelivery(self::DELIVERY_STREAMING);

        return $this;
    }

    /**
     * Either “progressive” for progressive download protocols (such as HTTP) or “streaming” for streaming protocols
     *
     * @param string $delivery One of MediaFile::DELIVERY_ constants
     *
     * @return MediaFile
     *
     * @throws \InvalidArgumentException
     */
    public function setDelivery(string $delivery): self
    {
        if (!in_array($delivery, [self::DELIVERY_PROGRESSIVE, self::DELIVERY_STREAMING])) {
            throw new \InvalidArgumentException('Wrong delivery specified');
        }

        $this->domElement->setAttribute('delivery', $delivery);

        return $this;
    }

    /**
     * MIME type for the file container. Popular MIME types include, but are not
     * limited to “video/mp4” for MP4, “audio/mpeg” and "audio/aac" for audio ads.
     *
     * @param string $mime
     *
     * @return MediaFile
     */
    public function setType(string $mime): self
    {
        $this->domElement->setAttribute('type', $mime);
        return $this;
    }

    /**
     * The native width of the video file, in pixels. (0 for audio ads)
     *
     * @param int $width
     *
     * @return MediaFile
     */
    public function setWidth(int $width): self
    {
        $this->domElement->setAttribute('width', (string)$width);

        return $this;
    }

    /**
     * The native height of the video file, in pixels. (0 for audio ads)
     *
     * @param int $height
     *
     * @return MediaFile
     */
    public function setHeight(int $height): self
    {
        $this->domElement->setAttribute('height', (string)$height);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return MediaFile
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

    /**
     * @param int $bitrate
     *
     * @return $this
     */
    public function setBitrate(int $bitrate): self
    {
        $this->domElement->setAttribute('bitrate', (string)$bitrate);

        return $this;
    }

    /**
     * @deprecated Please note that this attribute is deprecated since VAST 4.1 along with VPAID
     *
     * Identifies the API needed to execute an interactive media file, but current support is for backward
     * compatibility. Please use the <InteractiveCreativeFile> element to include files that
     * require an API for execution.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setApiFramework(string $value): self
    {
        $this->domElement->setAttribute('apiFramework', (string) $value);

        return $this;
    }
}
