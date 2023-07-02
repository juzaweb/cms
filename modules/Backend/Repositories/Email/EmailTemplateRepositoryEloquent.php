<?php

namespace Juzaweb\Backend\Repositories\Email;

use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\CMS\Traits\Criterias\UseFilterCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSearchCriteria;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class EmailTemplateRepositoryEloquent extends BaseRepositoryEloquent implements EmailTemplateRepository
{
    use UseSearchCriteria, UseFilterCriteria;

    protected array $searchableFields = ['code', 'subject'];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return EmailTemplate::class;
    }
}
