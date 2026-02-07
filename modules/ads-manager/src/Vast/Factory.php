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

class Factory
{
    /**
     * @var ElementBuilder
     */
    private $vastElementBuilder;

    /**
     * @param ElementBuilder $vastElementBuilder
     */
    public function __construct(ElementBuilder $vastElementBuilder = null)
    {
        if ($vastElementBuilder === null) {
            $vastElementBuilder = new ElementBuilder();
        }

        $this->vastElementBuilder = $vastElementBuilder;
    }

    /**
     * Create new VAST document
     *
     * @param string $vastVersion
     *
     * @return Document
     */
    public function create(string $vastVersion = '2.0'): Document
    {
        $xml = $this->createDomDocument();

        // root
        $root = $xml->createElement('VAST');
        $xml->appendChild($root);

        // version
        $vastVersionAttribute = $xml->createAttribute('version');
        $vastVersionAttribute->value = $vastVersion;
        $root->appendChild($vastVersionAttribute);

        // return
        return $this->vastElementBuilder->createDocument($xml);
    }

    /**
     * Create VAST document from file
     *
     * @param string $filename
     *
     * @return Document
     */
    public function fromFile(string $filename): Document
    {
        $xml = $this->createDomDocument();
        $xml->load($filename);

        return $this->vastElementBuilder->createDocument($xml);
    }

    /**
     * Create VAST document from given string with xml
     *
     * @param string $xmlString
     *
     * @return Document
     */
    public function fromString(string $xmlString): Document
    {
        $xml = $this->createDomDocument();
        $xml->loadXml($xmlString);

        return $this->vastElementBuilder->createDocument($xml);
    }

    /**
     * Create dom document
     *
     * @return \DomDocument
     */
    private function createDomDocument(): \DOMDocument
    {
        return new \DomDocument('1.0', 'UTF-8');
    }
}
