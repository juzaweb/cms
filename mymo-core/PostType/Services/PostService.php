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

namespace Mymo\PostType\Services;

use Illuminate\Support\Facades\DB;
use Mymo\PostType\PostType;
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
            PostType::syncTaxonomies('posts', $model, $attributes);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $this->validator($attributes);
        DB::beginTransaction();
        try {
            $model = $this->postRepository->update($attributes, $id);
            PostType::syncTaxonomies('posts', $model, $attributes);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $model;
    }

    /**
     * Delete post
     *
     * @param int|array $id
     * @return bool
     *
     * @throws \Exception
     */
    public function delete($id)
    {
        $ids = is_array($id) ? $id : [$id];
        foreach ($ids as $id) {
            try {
                DB::beginTransaction();
                $this->postRepository->delete($id);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return true;
    }

    protected function validate($attributes)
    {
        $validator = Validator::make($attributes, [
            'title' => 'required|string|max:250',
            'status' => 'required|in:draft,public,trash,private',
            'thumbnail' => 'nullable|string|max:150',
        ]);

        $validator->validate();
    }
}
