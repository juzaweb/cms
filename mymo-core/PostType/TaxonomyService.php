<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/31/2021
 * Time: 10:20 PM
 */

namespace Mymo\PostType;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Mymo\Core\Repositories\TaxonomyRepository;

class TaxonomyService
{
    protected $taxonomyRepository;

    public function __construct(TaxonomyRepository $taxonomyRepository)
    {
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function create(array $attributes)
    {
        $this->validator($attributes);
        DB::beginTransaction();
        try {
            $model = $this->taxonomyRepository->create($attributes);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $this->validator($attributes);
        DB::beginTransaction();
        try {
            $model = $this->taxonomyRepository->update($attributes, $id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $model;
    }

    public function delete($id)
    {
        return $this->taxonomyRepository->delete($id);
    }

    protected function validate($attributes)
    {
        $validator = Validator::make($attributes, [
            'name' => 'required|string|max:250',
            'status' => 'required|in:0,publish,trash,private',
            'thumbnail' => 'nullable|string|max:150',
        ]);

        $validator->validate();
    }
}