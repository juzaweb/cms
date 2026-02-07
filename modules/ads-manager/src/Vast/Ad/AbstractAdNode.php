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

namespace Juzaweb\Modules\AdsManagement\Vast\Ad;

use Juzaweb\Modules\AdsManagement\Vast\Creative\AbstractCreative;
use Juzaweb\Modules\AdsManagement\Vast\Document\AbstractNode;
use Juzaweb\Modules\AdsManagement\Vast\ElementBuilder;

abstract class AbstractAdNode extends AbstractNode
{
    /**
     * @var \DOMElement
     */
    private $domElement;

    /**
     * @var ElementBuilder
     */
    protected $vastElementBuilder;

    /**
     * @var \DOMElement
     */
    private $adDomElement;

    /**
     * Creatives
     *
     * @var array
     */
    private $creatives = [];

    /**
     * @var \DomElement
     */
    private $creativesDomElement;

    /**
     * @var \DomElement
     */
    private $extensionsDomElement;

    /**
     * @param \DOMElement $adDomElement instance of \Vast\Ad element
     * @param ElementBuilder $vastElementBuilder
     */
    public function __construct(\DOMElement $adDomElement, ElementBuilder $vastElementBuilder)
    {
        $this->adDomElement = $adDomElement;
        $this->domElement = $this->adDomElement->getElementsByTagName($this->getAdSubElementTagName())->item(0);
        $this->vastElementBuilder = $vastElementBuilder;
    }

    /**
     * Return type of ad (InLine or Wrapper)
     *
     * @return string
     */
    abstract public function getAdSubElementTagName(): string;

    /**
     * Instance of "\Vast\Ad\(InLine|Wrapper)" element
     *
     * @return \DOMElement
     */
    public function getDomElement(): \DOMElement
    {
        return $this->domElement;
    }

    /**
     * Get id for Ad element
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->adDomElement->getAttribute('id');
    }

    /**
     * Set 'id' attribute of 'ad' element
     *
     * @param string $id
     *
     * @return InLine|Wrapper|AbstractAdNode
     */
    public function setId(string $id): self
    {
        $this->adDomElement->setAttribute('id', $id);

        return $this;
    }

    /**
     * Format a VAST 3.0 response that groups multiple ads into a sequential pod of ads
     *
     * @param int $sequence a number greater than zero (0) that identifies the sequence in which an ad should play;
     *                      all <Ad> elements with sequence values are part of a pod and are intended to be played
     *                      in sequence
     *
     * @return InLine|Wrapper|AbstractAdNode
     */
    public function setSequence(int $sequence): self
    {
        $this->adDomElement->setAttribute('sequence', (string)$sequence);

        return $this;
    }

    /**
     * @return int
     */
    public function getSequence(): int
    {
        return (int)($this->adDomElement->getAttribute('sequence'));
    }

    /**
     * Set /Vast/Ad/Inline/AdSystem element
     *
     * @param string $adSystem
     *
     * @return InLine|Wrapper|AbstractAdNode
     */
    public function setAdSystem(string $adSystem): self
    {
        $this->setScalarNodeCdata('AdSystem', $adSystem);

        return $this;
    }

    /**
     * Get /Vast/Ad/Inline/AdSystem element
     *
     * @return string
     */
    public function getAdSystem(): string
    {
        $adSystem = $this->getScalarNodeValue('AdSystem');

        return $adSystem;
    }

    /**
     * @return string[]
     */
    abstract protected function getAvailableCreativeTypes(): array;

    /**
     * Build object for creative of given type
     *
     * @param string $type
     * @param \DOMElement $creativeDomElement
     *
     * @return AbstractCreative
     */
    abstract protected function buildCreativeElement(string $type, \DOMElement $creativeDomElement): AbstractCreative;

    /**
     * Create "creative" object of given type
     *
     * @param string $type
     *
     * @throws \Exception
     *
     * @return AbstractCreative
     */
    final protected function buildCreative(string $type): AbstractCreative
    {
        // check type
        if (!in_array($type, $this->getAvailableCreativeTypes())) {
            throw new \InvalidArgumentException(sprintf('Wrong creative specified: %s', $type));
        }

        // get container
        if (!$this->creativesDomElement) {
            // get creatives tag
            $this->creativesDomElement = $this->adDomElement->getElementsByTagName('Creatives')->item(0);
            if (!$this->creativesDomElement) {
                $this->creativesDomElement = $this->adDomElement->ownerDocument->createElement('Creatives');
                $this->getDomElement()->appendChild($this->creativesDomElement);
            }
        }

        // Creative dom element: <Creative></Creative>
        $creativeDomElement = $this->creativesDomElement->ownerDocument->createElement('Creative');
        $this->creativesDomElement->appendChild($creativeDomElement);

        // Creative type dom element: <Creative><Linear></Linear></Creative>
        $creativeTypeDomElement = $this->adDomElement->ownerDocument->createElement($type);
        $creativeDomElement->appendChild($creativeTypeDomElement);

        // object
        $creative = $this->buildCreativeElement($type, $creativeDomElement);

        $this->creatives[] = $creative;

        return $creative;
    }

        /**
     * Add Error tracking url.
     * Allowed multiple error elements.
     *
     * @param string $url
     *
     * @return AbstractAdNode
     */
    public function addError(string $url): self
    {
        $this->addCdataNode('Error', $url);

        return $this;
    }

    /**
     * Get previously set error tracking url value
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->getValuesOfArrayNode('Error');
    }

    /**
     * Add Impression tracking url
     * Allowed multiple impressions
     *
     * @param string $url A URI that directs the video player to a tracking resource file that the video player
     *        ust use to notify the ad server when the impression occurs.
     * @param string|null $id An ad server id for the impression. Impression URIs of the same id for an ad should
     *        be requested at the same time or as close in time as possible to help prevent
     *        discrepancies.
     *
     * @return AbstractAdNode
     */
    public function addImpression(string $url, string $id = null): self
    {
        $attributes = [];
        if ($id !== null) {
            $attributes['id'] = $id;
        }

        $this->addCdataNode(
            'Impression',
            $url,
            $attributes
        );

        return $this;
    }

    /**
     * Get previously set impression tracking url value
     *
     * @return array
     */
    public function getImpressions(): array
    {
        return $this->getValuesOfArrayNode('Impression');
    }

    /**
     * Add extension
     *
     * @param string $type
     * @param string $value
     *
     * @return AbstractAdNode
     */
    public function addExtension(string $type, string $value): self
    {
        // get container
        if (!$this->extensionsDomElement) {
            // get extensions tag
            $this->extensionsDomElement = $this->adDomElement->getElementsByTagName('Extensions')->item(0);
            if (!$this->extensionsDomElement) {
                $this->extensionsDomElement = $this->adDomElement->ownerDocument->createElement('Extensions');
                $this->getDomElement()->appendChild($this->extensionsDomElement);
            }
        }

        // Creative dom element
        $extensionDomElement = $this->extensionsDomElement->ownerDocument->createElement('Extension');
        $this->extensionsDomElement->appendChild($extensionDomElement);

        // create cdata
        $cdata = $this->adDomElement->ownerDocument->createCDATASection($value);

        // append
        $extensionDomElement->setAttribute('type', $type);
        $extensionDomElement->appendChild($cdata);

        return $this;
    }
}
