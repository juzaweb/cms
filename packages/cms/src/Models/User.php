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
use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Database\Factories\UserFactory;
use Juzaweb\Traits\ModelCache;
use Juzaweb\Traits\ResourceModel;

class User extends Authenticatable
{
    use Notifiable;
    use ResourceModel;
    use HasFactory;
    use ModelCache;

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
