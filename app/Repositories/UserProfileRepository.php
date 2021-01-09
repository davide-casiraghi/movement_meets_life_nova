<?php

namespace App\Repositories;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class UserProfileRepository implements UserProfileRepositoryInterface {

    /**
     * Get user profile by id
     *
     * @param int $id
     * @return UserProfile
     */
    public function getById(int $id): UserProfile
    {
        return UserProfile::findOrFail($id);
    }

    /**
     * Store UserProfile
     *
     * @param array $data
     * @return UserProfile
     */
    public function store(array $data): UserProfile
    {
        $userProfile = new UserProfile();

        $userProfile->user_id = $data['user_id'];
        $userProfile->additional_information = array_key_exists('additional_information', $data) ? $data['additional_information'] : '';

        $userProfile->name = $data['name'];
        $userProfile->surname = $data['surname'];
        $userProfile->phone = array_key_exists('phone', $data) ? $data['phone'] : '';
        $userProfile->ip = array_key_exists('ip', $data) ? $data['ip'] : '';

        $userProfile->save();

        return $userProfile->fresh();
    }

    /**
     * Update UserProfile
     *
     * @param array $data
     * @param int $userProfileId
     *
     * @return UserProfile
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(array $data, int $userProfileId): UserProfile
    {
        $userProfile = $this->getById($userProfileId);
        $userProfile->user_id = $userProfile->user->id;
        $userProfile->name = $data['name'];
        $userProfile->surname = $data['surname'];
        $userProfile->phone = $data['phone'];
        $userProfile->additional_information = $data['additional_information'] ?? null;

        $userProfile->region_id = $data['region_id'] ?? null;

        $userProfile->application_approved = (!empty($data['application_approved'])) ? 1 : 0;
        $userProfile->sms_alerts = (!empty($data['sms_alerts'])) ? 1 : 0;
        $userProfile->mail_alerts = (!empty($data['mail_alerts'])) ? 1 : 0;

        if ($userProfile->profile_completed_at === NULL){
            $userProfile->profile_completed_at = Date::now();
        }

        $userProfile->update();

        $userProfile->workTypes()->sync($data['work_type_id'] ?? null);
        $userProfile->genders()->sync($data['gender_id'] ?? null);
        $userProfile->alertRegions()->sync($data['alert_region_id'] ?? null);

        $this->updateUserStatus($userProfile, $data['status'] ?? null);

        return $userProfile;
    }

    /**
     * Delete UserProfile
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        UserProfile::destroy($id);
    }

    /**
     * Update the user status
     *
     * @param UserProfile $userProfile
     * @param string|null $status
     *
     * @return void
     */
    public function updateUserStatus(UserProfile $userProfile, ?string $status): void
    {
        // If the status dropdown has been modified change the status according to that
        if(isset($status) && $userProfile->user->status != $status) {
            $userProfile->user->setStatus($status);
        }

        // Otherwise set the status to update if any field has been modified
        elseif($userProfile->wasChanged()){
            $userProfile->user->setStatus('updated', Auth::id());
        }
    }

    /**
     * Update the user phone verify at field
     *
     * @param UserProfile $userProfile
     * @param Request $request
     *
     * @return bool
     */
    public function updateUserPhoneVerifyAt(UserProfile $userProfile, Request $request): bool
    {
        if(isset($request->phone_verification_code)){
            if ($userProfile->phone_verification_code == $request->phone_verification_code){
                $userProfile->phone_verified_at = Carbon::now();
                $userProfile->update();
                return true;
            }
        }
        return false;
    }

}