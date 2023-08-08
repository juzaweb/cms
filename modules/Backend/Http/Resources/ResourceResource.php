<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'metas' => $this->json_metas,
            'created_at' => jw_date_format($this->created_at),
            'updated_at' => jw_date_format($this->updated_at),
        ];
    }
}
