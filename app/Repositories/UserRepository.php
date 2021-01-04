<?php

namespace App\Repositories;

use App\Http\Requests\AdminStoreRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface {

    /**
     * Get all the administrators.
     *
     * @param int|null $recordsPerPage
     *
     * @param array|null $searchParameters
     *
     * @return iterable|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function administrators(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = User::role(['Super Admin', 'Admin'])->orderBy('username', 'asc');
        $query->with('profile');

        if(!is_null($searchParameters)) {
            if (!empty($searchParameters['username'])){
                $query->where('username', 'like', '%'.$searchParameters['username'].'%');
            }
            if (!empty($searchParameters['email'])){
                $query->where('email', 'like', '%'.$searchParameters['email'].'%');
            }
            if (!empty($searchParameters['userLevel'])){
                $query->role($searchParameters['userLevel']);
            }
            if (!empty($searchParameters['team'])){
                $query->role($searchParameters['team']);
            }
        }

        if($recordsPerPage){
            return $query->paginate($recordsPerPage);
        }
        return $query->get();
    }

    /**
     * Get all the members.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return iterable|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function members(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = User::role(['Individual', 'Organisation', 'Venue'])->orderBy('username', 'asc');
        $query->with('profile');

        if(!is_null($searchParameters)) {
            if (!empty($searchParameters['username'])){
                $query->where('username', 'like', '%'.$searchParameters['username'].'%');
            }
            if (!empty($searchParameters['email'])){
                $query->where('email', 'like', '%'.$searchParameters['email'].'%');
            }
            if (!empty($searchParameters['phone'])){
                $query->whereHas('profile', function($q) use ($searchParameters){
                    $q->where('phone', 'like', '%'.$searchParameters['phone'].'%');
                });
            }
            if (!empty($searchParameters['regionId'])){
                $query->whereHas('profile', function($q) use ($searchParameters){
                    $q->where('region_id', $searchParameters['regionId']);
                });
            }
            if (!empty($searchParameters['role'])){
                $query->role($searchParameters['role']);
            }
            if (!empty($searchParameters['startDate'])){
                $startDate = Carbon::createFromFormat('d/m/Y', $searchParameters['startDate']);
                $query->where('created_at', '>=', $startDate);
            }
            if (!empty($searchParameters['endDate'])){
                $endDate = Carbon::createFromFormat('d/m/Y', $searchParameters['endDate']);
                $query->where('created_at', '<=',$endDate);
            }
        }

        if($recordsPerPage){
            return $query->paginate($recordsPerPage);
        }
        return $query->get();
    }

    /**
     * Get user by id
     *
     * @param int $userId
     * @return User
     */
    public function getById(int $userId)
    {
        return User::findOrFail($userId);
    }

    /**
     * Store Member
     *
     * @param array $data
     * @return User
     */
    public function storeMember(array $data)
    {
        $user = new User();

        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = (array_key_exists('password', $data)) ? Hash::make($data['password']) : null;

        $user->heard_about_us = $data['heard_about_us'];
        $user->over_age_limit =  ($data['over_age_limit'] == 'on') ? 1 : 0;
        $user->accept_terms = ($data['accept_terms'] == 'on') ? 1 : 0;

        $user->save();

        return $user->fresh();
    }


    /**
     * Store Admin
     *
     * @param \App\Http\Requests\AdminStoreRequest $data
     * @return User
     */
    public function storeAdmin(AdminStoreRequest $data)
    {
        $user = new User();

        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        $user->save();

        return $user->fresh();
    }

    /**
     * Update User
     *
     * @param \App\Http\Requests\MemberStoreRequest|\App\Http\Requests\AdminStoreRequest  $data
     * @param int $userId
     * @return User
     */
    public function update($data, int $userId)
    {
        $user = $this->getById($userId);
        //dd($user->heard_about_us);
        $user->username = $data['username'];
        $user->email = $data['email'];
        if ($data->get('password')) {
            $user->password = Hash::make($data['password']);
        }
        $user->heard_about_us = $data['heard_about_us'];

        $user->over_age_limit =  ($data['over_age_limit'] == 'on') ? 1 : 0;
        $user->accept_terms = ($data['accept_terms'] == 'on') ? 1 : 0;

        $user->update();

        return $user;
    }

    /**
     * Delete User
     *
     * @param int $userId
     * @return void
     */
    public function delete(int $userId)
    {
        User::destroy($userId);
    }


}