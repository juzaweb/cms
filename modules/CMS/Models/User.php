<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Juzaweb\Backend\Models\Notification;
use Juzaweb\Backend\Models\PasswordReset;
use Juzaweb\Backend\Models\SocialToken;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Database\Factories\UserFactory;
use Juzaweb\CMS\Traits\Permission\HasRoles;
use Juzaweb\CMS\Traits\QueryCache\QueryCacheable;
use Juzaweb\CMS\Traits\ResourceModel;
use Juzaweb\Network\Facades\Network;
use Juzaweb\Network\Traits\RootNetworkModel;
use Laravel\Passport\HasApiTokens;

/**
 * Juzaweb\CMS\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $avatar
 * @property int $is_admin
 * @property string $status unconfimred, banned, active
 * @property string $language
 * @property string|null $verification_token
 * @property array|null $data
 * @property-read int|null $notifications_count
 * @method static Builder|User active()
 * @method static \Juzaweb\CMS\Database\Factories\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereData($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFilter($params = [])
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereLanguage($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereVerificationToken($value)
 * @mixin \Eloquent
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|User permission($permissions)
 * @method static Builder|User role($roles, $guard = null)
 * @property int|null $site_id
 * @property-read DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User whereSiteId($value)
 * @property array|null $json_metas
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\CMS\Models\UserMeta[] $metas
 * @property-read int|null $metas_count
 * @property-read PasswordReset|null $passwordReset
 * @method static Builder|User whereJsonMetas($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|SocialToken[] $socialTokens
 * @property-read int|null $social_tokens_count
 */
class User extends Authenticatable
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_VERIFICATION = 'verification';
    public const STATUS_BANNED = 'banned';

    use HasApiTokens,
        Notifiable,
        ResourceModel,
        HasFactory,
        HasRoles,
        RootNetworkModel,
        QueryCacheable;

    public string $cachePrefix = 'users_';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'status',
        'verification_token',
        'data',
        'json_metas',
        'language',
        'is_fake',
    ];

    protected $hidden = [
        'password',
    ];

    public $casts = [
        'data' => 'array',
        'json_metas' => 'array'
    ];

    public static function getAllStatus(): array
    {
        return [
            User::STATUS_ACTIVE => trans('cms::app.active'),
            User::STATUS_BANNED => trans('cms::app.banned'),
            User::STATUS_VERIFICATION => trans('cms::app.verification'),
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable')->latest();
    }

    public function passwordReset(): HasOne
    {
        return $this->hasOne(PasswordReset::class, 'email', 'email');
    }

    public function metas(): HasMany
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'id');
    }

    public function socialTokens(): HasMany
    {
        return $this->hasMany(SocialToken::class, 'user_id', 'id');
    }

    public function getMeta($key, $default = null): mixed
    {
        return $this->json_metas[$key] ?? $default;
    }

    public function getMetas(): ?array
    {
        return $this->json_metas;
    }

    public function setMeta($key, $value): void
    {
        $metas = $this->getMetas();

        $this->metas()->updateOrCreate(
            [
                'meta_key' => $key
            ],
            [
                'meta_value' => is_array($value) ? json_encode($value) : $value
            ]
        );

        $metas[$key] = $value;

        $this->update(
            [
                'json_metas' => $metas
            ]
        );
    }

    public function deleteMeta($key): bool
    {
        $this->metas()->where('meta_key', $key)->delete();

        $metas = $this->getMetas();

        unset($metas[$key]);

        $this->update(
            [
                'json_metas' => $metas
            ]
        );

        return true;
    }

    public function deleteMetas(array $keys): bool
    {
        $this->metas()->whereIn('meta_key', $keys)->delete();

        $metas = $this->getMetas();

        foreach ($keys as $key) {
            unset($metas[$key]);
        }

        $this->update(
            [
                'json_metas' => $metas
            ]
        );

        return true;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('status', '=', User::STATUS_ACTIVE);
    }

    public function getAvatar(string $size = null): string
    {
        if ($this->avatar) {
            return upload_url($this->avatar, null, $size);
        }

        return asset('jw-styles/juzaweb/images/avatar.png');
    }

    public function isAdmin(): bool
    {
        $permission = apply_filters(
            Action::BEFORE_PERMISSION_ADMIN,
            false,
            $this
        );

        if ($permission) {
            return true;
        }

        if ($this->is_admin) {
            return true;
        }

        $permission = apply_filters(
            Action::AFTER_PERMISSION_ADMIN,
            false,
            $this
        );

        if ($permission) {
            return true;
        }

        return false;
    }

    public function isMasterAdmin(): bool
    {
        if (config('network.enable')) {
            if ($this->isAdmin() && Network::isRootSite()) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission(): bool
    {
        if ($this->roles()->exists()) {
            return true;
        }

        return $this->permissions()->exists();
    }

    public function attributeLabel($key)
    {
        $label = Arr::get($this->attributeLabels(), $key);
        if (empty($label)) {
            $label = trans("cms::app.{$key}");
        }

        return $label;
    }

    public function attributeLabels(): array
    {
        return [];
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'users',
        ];
    }
}
