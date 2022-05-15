<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'label' => $this->label,
            'link' => $this->link,
            'type' => $this->type,
            'icon' => $this->icon,
            'target' => $this->target,
            'num_order' => $this->num_order,
            'is_active' => $this->isActive(),
        ];
    }
}
