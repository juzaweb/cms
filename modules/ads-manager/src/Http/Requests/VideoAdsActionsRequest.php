<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    larabizcom/larabiz
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\AdsManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\Modules\Core\Rules\AllExist;
use Juzaweb\Modules\AdsManagement\Models\VideoAds;

class VideoAdsActionsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'action' => ['required', Rule::in(app(VideoAds::class)->bulkActions())],
            'ids' => ['required', 'array', 'min:1', new AllExist('video_ads', 'id')],
        ];
    }
}
