<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Notification;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class NotificationRepositoryRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class NotificationRepositoryEloquent extends BaseRepositoryEloquent implements NotificationRepository
{
    public function model(): string
    {
        return Notification::class;
    }
}
