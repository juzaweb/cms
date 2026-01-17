<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\VideoSharing\Models\Channel;

class ChannelController extends ThemeController
{
    public function show(string $code)
    {
        $channel = Channel::findByCode($code);

        abort_if($channel === null, 404, __('itube::translation.channel_not_found'));

        $videos = $channel->videos()
            ->with(['media'])
            ->withTranslation()
            ->whereFrontend()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view(
            'itube::channel.show',
            compact('channel', 'videos')
        );
    }

    public function subscribe(Request $request, string $code)
    {
        $channel = Channel::findByCode($code);

        abort_if($channel === null, 404, __('itube::translation.channel_not_found'));

        $user = $request->user();

        if ($channel->subscribers()->where('user_id', $user->id)->exists()) {
            $channel->subscribers()->detach($user->id);
        } else {
            $channel->subscribers()->attach($user->id);
        }

        return $this->success(__('itube::translation.subscription_updated_successfully'));
    }
}
