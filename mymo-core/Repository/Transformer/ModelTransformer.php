<?php

namespace Tadcms\Repository\Transformer;

use League\Fractal\TransformerAbstract;
use Tadcms\Repository\Contracts\Transformable;

/**
 * Class ModelTransformer
 * @package Tadcms\Repository\Transformer
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class ModelTransformer extends TransformerAbstract
{
    public function transform(Transformable $model)
    {
        return $model->transform();
    }
}
