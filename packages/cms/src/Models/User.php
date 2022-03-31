<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Database\Factories\UserFactory;
use Juzaweb\Traits\ModelCache;
use Juzaweb\Traits\ResourceModel;
use Spatie\Permission\Traits\HasRoles;

/**
 * Juzaweb\Models\User
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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User active()
 * @method static \Juzaweb\Backend\Database\Factories\UserFactory factory(...$parameters)
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
 */
class User extends Authenticatable
{
    use Notifiable;
    use ResourceModel;
    use HasFactory;
    use ModelCache;
    use HasRoles;

    const STATUS_ACTIVE = 'active';
    const STATUS_VERIFICATION = 'verification';
    const STATUS_BANNED = 'banned';

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

    public $cacheTags = ['users_'];

    public $cachePrefix = 'users_';

    public static function getAllStatus()
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
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActive($builder)
    {
        return $builder->where('status', '=', User::STATUS_ACTIVE);
    }

    public function getAvatar()
    {
        if ($this->avatar) {
            return upload_url($this->avatar);
        }

        return asset('jw-styles/juzaweb/styles/images/avatar.png');
    }

    public function subscription()
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
    }

    public function isAdmin()
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

    public function attributeLabels()
    {
        return [];
    }
}
