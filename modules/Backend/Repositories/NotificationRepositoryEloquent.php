<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Notification;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class NotificationRepositoryRepositoryEloquent.
 *
 * @property Notification $model
 */
class NotificationRepositoryEloquent extends BaseRepositoryEloquent implements NotificationRepository
{
    public function model(): string
    {
        return Notification::class;
    }
}
