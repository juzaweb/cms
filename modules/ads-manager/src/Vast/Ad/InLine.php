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
use Juzaweb\Modules\AdsManagement\Vast\Creative\InLine\Linear as InLineAdLinearCreative;

class InLine extends AbstractAdNode
{
    /**
     * @public
     */
    const TAG_NAME = 'InLine';

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
     * Set Ad title
     *
     * @param string $value
     *
     * @return InLine
     */
    public function setAdTitle(string $value): self
    {
        $this->setScalarNodeCdata('AdTitle', $value);

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
     * @return AbstractCreative|InLineAdLinearCreative
     */
    protected function buildCreativeElement(string $type, \DOMElement $creativeDomElement): AbstractCreative
    {
        switch ($type) {
            case self::CREATIVE_TYPE_LINEAR:
                $creative = $this->vastElementBuilder->createInLineAdLinearCreative($creativeDomElement);
                break;
            default:
                throw new \RuntimeException(sprintf('Unknown Wrapper creative type %s', $type));
        }

        return $creative;
    }

    /**
     * Create Linear creative
     *
     * @throws \Exception
     *
     * @return InLineAdLinearCreative
     */
    public function createLinearCreative(): InLineAdLinearCreative
    {
        /** @var InLineAdLinearCreative $creative */
        $creative = $this->buildCreative(self::CREATIVE_TYPE_LINEAR);

        return $creative;
    }
}
