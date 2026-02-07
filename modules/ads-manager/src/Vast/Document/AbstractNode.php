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

namespace Juzaweb\Modules\AdsManagement\Vast\Document;

abstract class AbstractNode
{
    /**
     * Root DOM element, represented by this Node class.
     *
     * @return \DOMElement
     */
    abstract protected function getDomElement(): \DOMElement;

    /**
     * Set cdata for given child node or create new child node
     *
     * @param string $name name of node
     * @param string $value value of cdata
     *
     * @return AbstractNode
     */
    protected function setScalarNodeCdata($name, $value): self
    {
        // get tag
        $childDomElement = $this->getDomElement()->getElementsByTagName($name)->item(0);
        if ($childDomElement === null) {
            $childDomElement = $this->getDomElement()->ownerDocument->createElement($name);
            $this->getDomElement()->appendChild($childDomElement);
        }

        // upsert cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($value);
        if ($childDomElement->hasChildNodes()) {
            // update cdata
            $childDomElement->replaceChild($cdata, $childDomElement->firstChild);
        } else {
            // insert cdata
            $childDomElement->appendChild($cdata);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws \InvalidArgumentException when node not found
     */
    protected function getScalarNodeValue(string $name): string
    {
        $domElements = $this->getDomElement()->getElementsByTagName($name);
        if ($domElements->length === 0) {
            throw new \InvalidArgumentException(sprintf('Unknown scalar node %s', $name));
        }

        return $domElements->item(0)->nodeValue;
    }

    /**
     * Append new child node to node
     *
     * @param string $nodeName
     * @param string $value
     * @param array $attributes
     *
     * @return AbstractNode
     */
    protected function addCdataNode($nodeName, $value, array $attributes = []): self
    {
        // create element
        $domElement = $this->getDomElement()->ownerDocument->createElement($nodeName);
        $this->getDomElement()->appendChild($domElement);

        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($value);
        $domElement->appendChild($cdata);

        // add attributes
        foreach ($attributes as $attributeId => $attributeValue) {
            $domElement->setAttribute($attributeId, $attributeValue);
        }

        return $this;
    }

    /**
     * @param string $nodeName
     *
     * @return string[]
     */
    protected function getValuesOfArrayNode(string $nodeName): array
    {
        $domElements = $this->getDomElement()->getElementsByTagName($nodeName);

        $values = [];
        for ($i = 0; $i < $domElements->length; $i++) {
            $values[$i] = $domElements->item($i)->nodeValue;
        }

        return $values;
    }
}
