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

namespace Juzaweb\Modules\AdsManagement\Vast\Creative;

use Juzaweb\Modules\AdsManagement\Vast\ElementBuilder;

abstract class AbstractLinearCreative extends AbstractCreative
{
    /**
     * @var ElementBuilder
     */
    protected $vastElementBuilder;

    /**
     * this event should be used to indicate when the player considers that it has loaded
     * and buffered the creative’s media and assets either fully or to the extent that it is ready to play the media.
     */
    public const EVENT_TYPE_LOADED = 'loaded';

    /**
     * not to be confused with an impression, this event indicates that an individual creative
     * portion of the ad was viewed. An impression indicates the first frame of the ad was displayed; however
     * an ad may be composed of multiple creative, or creative that only play on some platforms and not
     * others. This event enables ad servers to track which ad creative are viewed, and therefore, which
     * platforms are more common.
     */
    public const EVENT_TYPE_CREATIVEVIEW = 'creativeView';

    /**
     * this event is used to indicate that an individual creative within the ad was loaded and playback
     * began. As with creativeView, this event is another way of tracking creative playback.
     */
    public const EVENT_TYPE_START = 'start';

    // the creative played for at least 25% of the total duration.
    public const EVENT_TYPE_FIRSTQUARTILE = 'firstQuartile';

    // the creative played for at least 50% of the total duration.
    public const EVENT_TYPE_MIDPOINT = 'midpoint';

    // the creative played for at least 75% of the duration.
    public const EVENT_TYPE_THIRDQUARTILE = 'thirdQuartile';

    // The creative was played to the end at normal speed.
    public const EVENT_TYPE_COMPLETE = 'complete';

    // the user activated the mute control and muted the creative.
    public const EVENT_TYPE_MUTE = 'mute';

    // the user activated the mute control and unmuted the creative.
    public const EVENT_TYPE_UNMUTE = 'unmute';

    // the user clicked the pause control and stopped the creative.
    public const EVENT_TYPE_PAUSE = 'pause';

    // the user activated the rewind control to access a previous point in the creative timeline.
    public const EVENT_TYPE_REWIND = 'rewind';

    // the user activated the resume control after the creative had been stopped or paused.
    public const EVENT_TYPE_RESUME = 'resume';

    // the user activated a control to extend the video player to the edges of the viewer’s screen.
    public const EVENT_TYPE_FULLSCREEN = 'fullscreen';

    // the user activated the control to reduce video player size to original dimensions.
    public const EVENT_TYPE_EXITFULLSCREEN = 'exitFullscreen';

    // the user activated a control to expand the creative.
    public const EVENT_TYPE_EXPAND = 'expand';

    // the user activated a control to reduce the creative to its original dimensions.
    public const EVENT_TYPE_COLLAPSE = 'collapse';

    /**
     * The user activated a control that launched an additional portion of the
     * creative. The name of this event distinguishes it from the existing “acceptInvitation” event described in
     * the 2008 IAB Digital Video In-Stream Ad Metrics Definitions, which defines the “acceptInivitation”
     * metric as applying to non-linear ads only. The “acceptInvitationLinear” event extends the metric for use
     * in Linear creative.
     */
    public const EVENT_TYPE_ACCEPTINVITATIONLINEAR = 'acceptInvitationLinear';

    /**
     * The user clicked the close button on the creative. The name of this event distinguishes it
     * from the existing “close” event described in the 2008 IAB Digital Video In-Stream Ad Metrics
     * Definitions, which defines the “close” metric as applying to non-linear ads only. The “closeLinear” event
     * extends the “close” event for use in Linear creative.
     * Available in VAST v.3, not available in VAST v.4
     */
    public const EVENT_TYPE_CLOSELINEAR = 'closeLinear';

    // the user activated a skip control to skip the creative, which is a
    // different control than the one used to close the creative.
    public const EVENT_TYPE_SKIP = 'skip';

    /**
     * the creative played for a duration at normal speed that is equal to or greater than the
     * value provided in an additional attribute for offset . Offset values can be time in the format
     * HH:MM:SS or HH:MM:SS.mmm or a percentage value in the format n% . Multiple progress ev
     */
    public const EVENT_TYPE_PROGRESS = 'progress';

    /**
     * Dom Element of <Creative></Creative>
     *
     * @var \DOMElement
     */
    private $linearCreativeDomElement;

    /**
     * @var \DOMElement
     */
    private $videoClicksDomElement;

    /**
     * @var \DOMElement
     */
    private $trackingEventsDomElement;

    /**
     * @param \DOMElement $linearCreativeDomElement
     * @param ElementBuilder $vastElementBuilder
     */
    public function __construct(\DOMElement $linearCreativeDomElement, ElementBuilder $vastElementBuilder)
    {
        $this->linearCreativeDomElement = $linearCreativeDomElement;
        $this->vastElementBuilder = $vastElementBuilder;
    }

    /**
     * Dom Element of <Creative></Creative>
     *
     * @return \DOMElement
     */
    protected function getDomElement(): \DOMElement
    {
        return $this->linearCreativeDomElement;
    }

    /**
     * List of allowed events
     *
     * @return array
     */
    public static function getEventList(): array
    {
        return [
            self::EVENT_TYPE_LOADED,
            self::EVENT_TYPE_CREATIVEVIEW,
            self::EVENT_TYPE_START,
            self::EVENT_TYPE_FIRSTQUARTILE,
            self::EVENT_TYPE_MIDPOINT,
            self::EVENT_TYPE_THIRDQUARTILE,
            self::EVENT_TYPE_COMPLETE,
            self::EVENT_TYPE_MUTE,
            self::EVENT_TYPE_UNMUTE,
            self::EVENT_TYPE_PAUSE,
            self::EVENT_TYPE_REWIND,
            self::EVENT_TYPE_RESUME,
            self::EVENT_TYPE_FULLSCREEN,
            self::EVENT_TYPE_EXITFULLSCREEN,
            self::EVENT_TYPE_EXPAND,
            self::EVENT_TYPE_COLLAPSE,
            self::EVENT_TYPE_ACCEPTINVITATIONLINEAR,
            self::EVENT_TYPE_CLOSELINEAR,
            self::EVENT_TYPE_SKIP,
            self::EVENT_TYPE_PROGRESS,
        ];
    }

    /**
     * Get VideoClicks DomElement
     *
     * @return \DOMElement
     */
    protected function getVideoClicksDomElement(): \DOMElement
    {
        // create container
        if (!empty($this->videoClicksDomElement)) {
            return $this->videoClicksDomElement;
        }

        $this->videoClicksDomElement = $this->linearCreativeDomElement->getElementsByTagName('VideoClicks')->item(0);
        if (!empty($this->videoClicksDomElement)) {
            return $this->videoClicksDomElement;
        }

        $this->videoClicksDomElement = $this->linearCreativeDomElement->ownerDocument->createElement('VideoClicks');
        $this->linearCreativeDomElement
            ->getElementsByTagName('Linear')
            ->item(0)
            ->appendChild($this->videoClicksDomElement);

        return $this->videoClicksDomElement;
    }

    /**
     * Add click tracking url
     *
     * @param string $url
     *
     * @return AbstractLinearCreative
     */
    public function addVideoClicksClickTracking(string $url): self
    {
        // create ClickTracking
        $clickTrackingDomElement = $this->getDomElement()->ownerDocument->createElement('ClickTracking');
        $this->getVideoClicksDomElement()->appendChild($clickTrackingDomElement);

        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($url);
        $clickTrackingDomElement->appendChild($cdata);

        return $this;
    }

    /**
     * Add custom click url
     *
     * @param string $url
     *
     * @return AbstractLinearCreative
     */
    public function addVideoClicksCustomClick(string $url): self
    {
        // create CustomClick
        $customClickDomElement = $this->getDomElement()->ownerDocument->createElement('CustomClick');
        $this->getVideoClicksDomElement()->appendChild($customClickDomElement);

        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($url);
        $customClickDomElement->appendChild($cdata);

        return $this;
    }

    /**
     * Set video click through url
     *
     * @param string $url
     *
     * @return AbstractLinearCreative
     */
    public function setVideoClicksClickThrough(string $url): self
    {
        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($url);

        // create ClickThrough
        $clickThroughDomElement = $this->getVideoClicksDomElement()->getElementsByTagName('ClickThrough')->item(0);
        if (!$clickThroughDomElement) {
            $clickThroughDomElement = $this->getDomElement()->ownerDocument->createElement('ClickThrough');
            $this->getVideoClicksDomElement()->appendChild($clickThroughDomElement);
        }

        // update CData
        if ($clickThroughDomElement->hasChildNodes()) {
            $clickThroughDomElement->replaceChild($cdata, $clickThroughDomElement->firstChild);
        } else { // insert CData
            $clickThroughDomElement->appendChild($cdata);
        }

        return $this;
    }

    /**
     * Get TrackingEvents DomElement
     *
     * @return \DOMElement
     */
    protected function getTrackingEventsDomElement(): \DOMElement
    {
        // create container
        if ($this->trackingEventsDomElement) {
            return $this->trackingEventsDomElement;
        }

        $this->trackingEventsDomElement = $this->linearCreativeDomElement
            ->getElementsByTagName('TrackingEvents')
            ->item(0);

        if ($this->trackingEventsDomElement) {
            return $this->trackingEventsDomElement;
        }

        $this->trackingEventsDomElement = $this->linearCreativeDomElement
            ->ownerDocument
            ->createElement('TrackingEvents');

        $this->linearCreativeDomElement
            ->getElementsByTagName('Linear')
            ->item(0)
            ->appendChild($this->trackingEventsDomElement);

        return $this->trackingEventsDomElement;
    }

    /**
     * @param string $event
     * @param string $url
     *
     * @return AbstractLinearCreative
     *
     * @throws \Exception
     */
    public function addTrackingEvent(string $event, string $url): self
    {
        if (!in_array($event, $this->getEventList())) {
            throw new \Exception(sprintf('Wrong event "%s" specified', $event));
        }

        // create Tracking
        $trackingDomElement = $this->linearCreativeDomElement->ownerDocument->createElement('Tracking');
        $this->getTrackingEventsDomElement()->appendChild($trackingDomElement);

        // add event attribute
        $trackingDomElement->setAttribute('event', $event);

        // create cdata
        $cdata = $this->linearCreativeDomElement->ownerDocument->createCDATASection($url);
        $trackingDomElement->appendChild($cdata);

        return $this;
    }

    /**
     * @param string $url
     * @param int|string $offset seconds or time in format "H:m:i" or percents in format "n%"
     *
     * @return AbstractLinearCreative
     */
    public function addProgressTrackingEvent(string $url, $offset): self
    {
        // create Tracking
        $trackingDomElement = $this->linearCreativeDomElement->ownerDocument->createElement('Tracking');
        $this->getTrackingEventsDomElement()->appendChild($trackingDomElement);

        // add event attribute
        $trackingDomElement->setAttribute('event', self::EVENT_TYPE_PROGRESS);

        // add offset attribute
        if (is_numeric($offset)) {
            $offset = $this->secondsToString($offset);
        }
        $trackingDomElement->setAttribute('offset', $offset);

        // create cdata
        $cdata = $this->linearCreativeDomElement->ownerDocument->createCDATASection($url);
        $trackingDomElement->appendChild($cdata);

        return $this;
    }

    /**
     * Convert seconds to H:m:i
     * Hours could be more than 24
     *
     * @param mixed $seconds
     *
     * @return string
     */
    protected function secondsToString($seconds)
    {
        $seconds = (int) $seconds;

        $time = [];

        // get hours
        $hours = floor($seconds / 3600);
        $time[] = str_pad((string)$hours, 2, '0', STR_PAD_LEFT);

        // get minutes
        $seconds = $seconds % 3600;
        $time[] = str_pad((string)floor($seconds / 60), 2, '0', STR_PAD_LEFT);

        // get seconds
        $time[] = str_pad((string)($seconds % 60), 2, '0', STR_PAD_LEFT);

        return implode(':', $time);
    }
}
