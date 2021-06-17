<?php

namespace Mymo\Repository\Transformer;

use League\Fractal\TransformerAbstract;
use Mymo\Repository\Contracts\Transformable;

/**
 * Class ModelTransformer
 * @package Mymo\Repository\Transformer
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class ModelTransformer extends TransformerAbstract
{
    public function transform(Transformable $model)
    {
        return $model->transform();
    }
}
