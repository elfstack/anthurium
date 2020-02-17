<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

use App\Models\Activity;
use App\Models\Participant;
use App\Models\Attendance;

use App\Exceptions\UserNotParticipatedException;
use App\Exceptions\UserAlreadyCheckedInException;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use ProcessMediaTrait;

    use HasRoles;

    protected $guards = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/api/user/'.$this->getKey());
    }

    /**
     * Get url of avatar image
     *
     * @return string|null
     */
    public function getAvatarThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatar', 'thumb_150') ?: null;
    }

    /* ************************ MEDIA ************************ */

    /**
     * Register media collections
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')
            ->accepts('image/*');
    }

    /**
     * Register media conversions
     *
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->autoRegisterThumb200();

        $this->addMediaConversion('thumb_75')
            ->width(75)
            ->height(75)
            ->fit('crop', 75, 75)
            ->optimize()
            ->performOnCollections('avatar')
            ->nonQueued();

        $this->addMediaConversion('thumb_150')
            ->width(150)
            ->height(150)
            ->fit('crop', 150, 150)
            ->optimize()
            ->performOnCollections('avatar')
            ->nonQueued();
    }

    /**
     * Auto register thumb overridden
     */
    public function autoRegisterThumb200()
    {
        $this->getMediaCollections()->filter->isImage()->each(function ($mediaCollection) {
            $this->addMediaConversion('thumb_200')
                ->width(200)
                ->height(200)
                ->fit('crop', 200, 200)
                ->optimize()
                ->performOnCollections($mediaCollection->getName())
                ->nonQueued();
        });
    }

    /* ************************ RELATIONS ************************ */

    public function volunteerInfo()
    {
        return $this->hasOne(\App\Models\VolunteerInfo::class);
    }

    public function activitiesParticipated()
    {
        return $this->belongsToMany(Activity::class, 'participants', 'user_id', 'activity_id')->using(Participant::class);
    }

    public function isParticipant(Activity $activity)
    {
        // TODO: might have better solution
        return $this->activitiesParticipated()->wherePivot('activity_id', $activity->id)->exists();
    }

    public function attendance() {
        return $this->hasMany(Attendance::class);
    } 

    public function enroll(Activity $activity)
    {
        if ($this->isParticipant($activity)) {
            return false;
        }

        $this->activitiesParticipated()->attach($activity->id);

        return true;
    }

    public function drop(Activity $activity)
    {
        if ($this->isParticipant($activity) && !$this->isCheckedIn($activity)) {
            $this->activitiesParticipated()->detach($activity->id);
        }
    }

    private function isCheckedIn(Activity $activity) {
        // TODO: performance needs to be improved
        return $activity->attendance()->where('user_id', $this->id)->exists();
    }

    public function checkin(Activity $activity)
    {
        if (!$this->isParticipant($activity)) {
            throw new UserNotParticipatedException("User is not a participant for this activity");
        }


        if ($this->isCheckedIn($activity)) {
            throw new UserAlreadyCheckedInException("User already checked in");
        }
        
        $attendance = $activity->attendance()->create([
            'arrived_at' => now(),
            'user_id' => $this->id
        ]);

        $this->activitiesParticipated()->wherePivot('activity_id', $activity->id)->update(['attendance_id' => $attendance->id]);

        return $attendance;
    }
}
