<?php namespace Juzaweb\CMS\Repositories\Transformer;

use Juzaweb\CMS\Repositories\Contracts\Transformable;
use League\Fractal\TransformerAbstract;

/**
 * Class ModelTransformer
 *
 * @package Prettus\Repository\Transformer
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class ModelTransformer extends TransformerAbstract
{
    public function transform(Transformable $model)
    {
        return $model->transform();
    }
}
