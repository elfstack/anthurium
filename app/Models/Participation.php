<?php

namespace App\Models;

use App\Exceptions\AlreadyProcessedException;
use App\Exceptions\InactiveActivityException;
use App\Exceptions\NotAdmittedException;
use App\Exceptions\NotCheckedInException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Support\InteractsWithTime;

class Participation extends MorphPivot
{

    use InteractsWithTime;
    /**
     * @var string table for this model
     */
    protected $table = 'participations';

    /**
     * @var string[] attributes appended
     */
    protected $appends = ['participation_status', 'attend_status'];

    /**
     * @var string[] columns need to be cast
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'arrived_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function otp()
    {
        $parameters = [
            'id' => $this->id,
            'expires' => $this->availableAt(Carbon::now()->addSeconds(10))
        ];

        return serialize($parameters + [ 'signature' => hash_hmac('sha256', serialize($parameters), getenv('APP_KEY'))]);
    }

    public function participant()
    {
        return $this->morphTo();
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Participation Status
     *
     * @return string
     */
    public function getParticipationStatusAttribute(): string
    {
        if ($this->cancelled_at) {
            return 'cancelled';
        }

        if ($this->rejected_at) {
            return 'rejected';
        }

        if ($this->approved_at) {
            return 'admitted';
        }

        return 'pending';
    }

    /**
     * Attend status
     *
     * @return string
     */
    public function getAttendStatusAttribute(): string
    {
        if ($this->left_at) {
            return 'left';
        }

        if ($this->arrived_at) {
           return 'attended';
        } else {
            return 'unattended';
        }
    }

    /**
     * Reject the participation request
     *
     * @throws AlreadyProcessedException
     */
    public function reject()
    {
        $this->checkIfAlreadyProcessed();
        $this->rejected_at = Carbon::now();
        $this->save();
    }

    /**
     * Approve participation request
     *
     * @throws AlreadyProcessedException
     */
    public function admit()
    {
        $this->checkIfAlreadyProcessed();

        $this->approved_at = Carbon::now();
        $this->save();
    }

    /**
     * Check in participant
     *
     * @throws NotAdmittedException
     * @throws InactiveActivityException
     * @throws AlreadyProcessedException
     */
    public function checkIn()
    {
        $this->beforeCheckIn();
        $this->arrived_at = Carbon::now();
        $this->save();
    }


    /**
     * Check out participant
     *
     * @throws InactiveActivityException
     * @throws NotAdmittedException
     * @throws NotCheckedInException
     */
    public function checkOut()
    {
        $this->beforeCheckIn();

        if ($this->getParticipationStatusAttribute() != 'admitted') {
            throw new NotAdmittedException();
        }

        if ($this->getAttendStatusAttribute() != 'attended') {
            throw new NotCheckedInException();
        }

        $this->left_at = Carbon::now();
        $this->save();
    }

    /**
     * @throws InactiveActivityException
     */
    private function checkActivityStatus()
    {
        if ($this->pivotParent->getStatus() != 'ongoing') {
            throw new InactiveActivityException();
        }
    }

    /**
     * @throws AlreadyProcessedException
     */
    private function checkIfAlreadyProcessed()
    {
        if ($this->getParticipationStatusAttribute() != 'pending') {
            throw new AlreadyProcessedException('already admitted or rejected');
        }
    }

    /**
     * Check conditions before check in
     *
     * @throws NotAdmittedException
     * @throws InactiveActivityException
     */
    private function beforeCheckIn()
    {
        $this->checkActivityStatus();

        if ($this->getParticipationStatusAttribute() != 'admitted') {
            throw new NotAdmittedException();
        }
    }
}
