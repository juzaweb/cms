<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/2/2021
 * Time: 1:46 PM
 */

namespace Mymo\Repository\Traits;

use Mymo\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

trait RepositoryEventTrait
{
    /**
     * @param RepositoryInterface $repository
     * @param Model               $model
     */
    public function entityDeleting(RepositoryInterface $repository, Model $model)
    {
    }

    public function entityDeleted(RepositoryInterface $repository, Model $model)
    {
    }

    public function entityCreating(RepositoryInterface $repository, array $attributes)
    {
    }

    public function entityCreated(
        RepositoryInterface $repository,
        Model $model,
        array $attributes
    ) {
    }

    public function entityUpdating(RepositoryInterface $repository, Model $model)
    {
    }

    public function entityUpdated(
        RepositoryInterface $repository,
        Model $model,
        array $attributes
    ) {
    }
}
