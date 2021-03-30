<?php

namespace App\Models;

use App\Utils\ConfigUtils;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements Participant, HasMedia, UserInterface
{
    use Notifiable;
    use HasApiTokens;
    use CanParticipate;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'user_group_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
            ->singleFile();
    }

    /**
     * Register media conversions
     *
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->width(200)
            ->height(200)
            ->performOnCollections('avatars');

    }

    public function actions(): HasMany
    {
         return $this->hasMany(Action::class);
    }

    public function pendingActions()
    {
        return $this->actions()->whereNull('completed_at');
    }

    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class);
    }

    /**
     * Set user group
     *
     * @param string|UserGroup $userGroup
     * @return Model
     */
    public function setUserGroup($userGroup=null)
    {
//        if ($userGroup == null) {
//            $userGroup = ConfigUtils::get('user.guest_group');
//        }
//
//        if (!$userGroup instanceof UserGroup) {
//            $userGroup = UserGroup::where('name', $userGroup)->first();
//        }
        $userGroup = UserGroup::where('name', 'guest')->first();

        return $this->userGroup()->associate($userGroup);
    }

    public function isAdmin()
    {
        return false;
    }
}
