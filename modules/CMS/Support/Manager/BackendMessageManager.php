<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Manager;

use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\BackendMessageContract;
use Juzaweb\CMS\Support\Config;

class BackendMessageManager implements BackendMessageContract
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function all(): array
    {
        return get_config('backend_messages', []);
    }

    public function add(string $group, array|string $message, string $status): void
    {
        if (!is_array($message)) {
            $message = [$message];
        }

        $data = $this->all();

        foreach ($message as $msg) {
            $id = Str::uuid()->toString();
            $data[$id] = [
                'id' => $id,
                'group' => $group,
                'status' => $status,
                'message' => $msg,
            ];
        }

        $this->config->setConfig('backend_messages', $data);
    }

    public function delete(string $id): bool
    {
        $data = collect($this->all());

        $data = $data->forget([$id])->all();

        $this->config->setConfig('backend_messages', $data);

        return true;
    }

    public function deleteGroup(string $group): bool
    {
        $data = collect($this->all());

        $ids = $data->where('group', $group)->pluck('id')->toArray();

        $data = $data->forget($ids);

        $this->config->setConfig('backend_messages', $data);

        return true;
    }
}
