<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Juzaweb\Backend\Models\PasswordReset;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Database\Factories\UserFactory;
use Juzaweb\CMS\Traits\Permission\HasRoles;
use Juzaweb\CMS\Traits\ResourceModel;
use Juzaweb\Network\Facades\Network;
use Juzaweb\Network\Traits\RootNetworkModel;
use Laravel\Sanctum\HasApiTokens;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User whereSiteId($value)
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use ResourceModel;
    use HasFactory;
    use HasRoles;
    use RootNetworkModel;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_VERIFICATION = 'verification';
    public const STATUS_BANNED = 'banned';

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'status',
        'verification_token',
        'data',
    ];

    protected $hidden = [
        'password',
    ];

    public $casts = [
        'data' => 'array'
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

    public function passwordReset(): HasOne
    {
        return $this->hasOne(PasswordReset::class, 'email', 'email');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('status', '=', User::STATUS_ACTIVE);
    }

    public function getAvatar(): string
    {
        if ($this->avatar) {
            return upload_url($this->avatar);
        }

        return asset('jw-styles/juzaweb/images/avatar.png');
    }

    /*public function subscription()
    {
        return $this->hasOne(
            UserSubscription::class,
            'user_id',
            'id'
        );
    }

    public function subscriptionHistories()
    {
        return $this->hasMany(SubscriptionHistory::class, 'user_id', 'id');
    }*/

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
}
