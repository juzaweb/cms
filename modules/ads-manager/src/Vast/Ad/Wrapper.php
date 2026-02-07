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
use Juzaweb\Modules\AdsManagement\Vast\Creative\Wrapper\Linear as WrapperAdLinearCreative;

class Wrapper extends AbstractAdNode
{
    /**
     * @public
     */
    const TAG_NAME = 'Wrapper';

    /**
     * @private
     */
    const CREATIVE_TYPE_LINEAR = 'Linear';

    /**
     * @return string
     */
    public function getAdSubElementTagName(): string
    {
        return self::TAG_NAME;
    }

    /**
     * URI of ad tag of downstream Secondary Ad Server
     *
     * @param string $uri
     *
     * @return Wrapper
     */
    public function setVASTAdTagURI(string $uri): self
    {
        $this->setScalarNodeCdata('VASTAdTagURI', $uri);

        return $this;
    }

    /**
     * @return string[]
     */
    protected function getAvailableCreativeTypes(): array
    {
        return [
            self::CREATIVE_TYPE_LINEAR,
        ];
    }

    /**
     * @param string $type
     * @param \DOMElement $creativeDomElement
     *
     * @return AbstractCreative|WrapperAdLinearCreative
     */
    protected function buildCreativeElement(string $type, \DOMElement $creativeDomElement): AbstractCreative
    {
        switch ($type) {
            case self::CREATIVE_TYPE_LINEAR:
                $creative = $this->vastElementBuilder->createWrapperAdLinearCreative($creativeDomElement);
                break;
            default:
                throw new \RuntimeException(sprintf('Unknown Wrapper creative type %s', $type));
        }

        return $creative;
    }

    /**
     * Create Linear creative
     *
     * @return WrapperAdLinearCreative
     *
     * @throws \Exception
     */
    public function createLinearCreative(): WrapperAdLinearCreative
    {
        /** @var WrapperAdLinearCreative $creative */
        $creative = $this->buildCreative(self::CREATIVE_TYPE_LINEAR);

        return $creative;
    }
}
