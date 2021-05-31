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
 * Date: 5/30/2021
 * Time: 3:19 PM
 */

namespace Mymo\PostType;

use Illuminate\Support\Facades\DB;
use Mymo\PostType\Repositories\PostRepository;
use Illuminate\Support\Facades\Validator;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create(array $attributes)
    {
        $this->validator($attributes);
        DB::beginTransaction();
        try {
            $model = $this->postRepository->create($attributes);
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
            $model = $this->postRepository->update($attributes, $id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $model;
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    protected function validate($attributes)
    {
        $validator = Validator::make($attributes, [
            'title' => 'required|string|max:250',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:150',
            'category' => 'nullable|string|max:200',
        ]);

        $validator->setAttributeNames([
            'title' => trans('mymo_core::app.title'),
            'status' => trans('mymo_core::app.status'),
            'thumbnail' => trans('mymo_core::app.thumbnail'),
            'category' => trans('mymo_core::app.categories'),
        ]);

        $validator->validate();
    }
}
