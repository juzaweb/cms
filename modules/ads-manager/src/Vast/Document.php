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

namespace Juzaweb\Modules\AdsManagement\Vast;

use Juzaweb\Modules\AdsManagement\Vast\Ad\AbstractAdNode;
use Juzaweb\Modules\AdsManagement\Vast\Ad\InLine;
use Juzaweb\Modules\AdsManagement\Vast\Ad\Wrapper;
use Juzaweb\Modules\AdsManagement\Vast\Document\AbstractNode;

class Document extends AbstractNode
{
    /**
     * @var \DOMDocument
     */
    private $domDocument;

    /**
     * @var ElementBuilder
     */
    private $vastElementBuilder;

    /**
     * Ad node list
     *
     * @var AbstractAdNode[]
     */
    private $vastAdNodeList = [];

    /**
     * @param \DOMDocument $DOMDocument
     */
    public function __construct(\DOMDocument $DOMDocument, ElementBuilder $vastElementBuilder)
    {
        $this->domDocument = $DOMDocument;
        $this->vastElementBuilder = $vastElementBuilder;
    }

    /**
     * @return \DOMElement
     */
    protected function getDomElement(): \DOMElement
    {
        return $this->domDocument->documentElement;
    }

    /**
     * "Magic" method to convert document to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->domDocument->saveXML();
    }

    /**
     * Get DomDocument object
     *
     * @return \DomDocument
     */
    public function toDomDocument(): \DOMDocument
    {
        return $this->domDocument;
    }

    /**
     * Create "Ad" section on "VAST" node
     *
     * @param string $type
     *
     * @throws \InvalidArgumentException
     *
     * @return AbstractAdNode|InLine|Wrapper
     */
    private function createAdSection($type): AbstractAdNode
    {
        // Check Ad type
        if (!in_array($type, [InLine::TAG_NAME, Wrapper::TAG_NAME])) {
            throw new \InvalidArgumentException(sprintf('Ad type %s not supported', $type));
        }

        // create dom node
        $adDomElement = $this->domDocument->createElement('Ad');
        $this->domDocument->documentElement->appendChild($adDomElement);

        // create type element
        $adTypeDomElement = $this->domDocument->createElement($type);
        $adDomElement->appendChild($adTypeDomElement);

        // create ad section
        switch ($type) {
            case InLine::TAG_NAME:
                $adSection = $this->vastElementBuilder->createInLineAdNode($adDomElement);
                break;
            case Wrapper::TAG_NAME:
                $adSection = $this->vastElementBuilder->createWrapperAdNode($adDomElement);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Ad type %s not supported', $type));
        }

        // cache
        $this->vastAdNodeList[] = $adSection;

        return $adSection;
    }

    /**
     * Create inline Ad section
     *
     * @return \Juzaweb\Modules\AdsManagement\Vast\Ad\InLine
     */
    public function createInLineAdSection(): InLine
    {
        return $this->createAdSection(InLine::TAG_NAME);
    }

    /**
     * Create Wrapper Ad section
     *
     * @return \Juzaweb\Modules\AdsManagement\Vast\Ad\Wrapper
     */
    public function createWrapperAdSection(): Wrapper
    {
        return $this->createAdSection(Wrapper::TAG_NAME);
    }

    public function createAdBreak(string $timeOffset, string $breakType = 'linear', string $breakId = null)
    {
        $adBreakElement = $this->toDomDocument()->createElement('AdBreak');
        $adBreakElement->setAttribute('timeOffset', $timeOffset);
        $adBreakElement->setAttribute('breakType', $breakType);
        if ($breakId) {
            $adBreakElement->setAttribute('breakId', $breakId);
        }

        $this->toDomDocument()->documentElement->appendChild($adBreakElement);

        return $adBreakElement;
    }

    /**
     * Get document ad sections
     *
     * @return AbstractAdNode[]
     *
     * @throws \Exception
     */
    public function getAdSections(): array
    {
        if (!empty($this->vastAdNodeList)) {
            return $this->vastAdNodeList;
        }

        foreach ($this->domDocument->documentElement->childNodes as $adDomElement) {
            // get Ad tag
            if (!$adDomElement instanceof \DOMElement) {
                continue;
            }

            if ('ad' !== strtolower($adDomElement->tagName)) {
                continue;
            }

            // get Ad type tag
            foreach ($adDomElement->childNodes as $node) {
                if (!($node instanceof \DOMElement)) {
                    continue;
                }

                $type = $node->tagName;

                // create ad section
                switch ($type) {
                    case InLine::TAG_NAME:
                        $adSection = $this->vastElementBuilder->createInLineAdNode($adDomElement);
                        break;
                    case Wrapper::TAG_NAME:
                        $adSection = $this->vastElementBuilder->createWrapperAdNode($adDomElement);
                        break;
                    default:
                        throw new \Exception('Ad type ' . $type . ' not supported');
                }

                $this->vastAdNodeList[] = $adSection;
            }
        }

        return $this->vastAdNodeList;
    }

    /**
     * Add Error tracking url.
     * Allowed multiple error elements.
     *
     * @param string $url
     *
     * @return Document
     */
    public function addErrors(string $url): self
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
}
