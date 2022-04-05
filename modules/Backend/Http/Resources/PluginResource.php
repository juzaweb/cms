<?php

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PluginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'code' => $this->getMeta('code'),
            'title' => $this->title,
            'thumbnail' => $this->getThumbnail(),
            'banner' => upload_url($this->getMeta('banner')),
            'description' => $this->description,
        ];
    }
}
