<?php

namespace App\Repositories;

use App\Http\Requests\AdminStoreRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Get all the users.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return iterable|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function users(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = User::orderBy('email', 'asc');
        $query->with('profile');

        if(!is_null($searchParameters)) {
            /*if (!empty($searchParameters['username'])){
                $query->where('username', 'like', '%'.$searchParameters['username'].'%');
            }*/
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
     * Store User
     *
     * @param array $data
     * @return User
     */
    public function storeUser(array $data)
    {
        $user = new User();

        $user->email = $data['email'];
        $user->password = (array_key_exists('password', $data)) ? Hash::make($data['password']) : null;

        $user->save();

        return $user->fresh();
    }

    /**
     * Update User
     *
     * @param array $data
     * @param int $userId
     * @return User
     */
    public function update(array $data, int $userId)
    {
        $user = $this->getById($userId);
        //dd($user->heard_about_us);
        $user->email = $data['email'];
        if (array_key_exists('password', $data)) {
            $user->password = Hash::make($data['password']);
        }

        //$user->profile->name = $data['name'];
        //$user->profile->surname = $data['surname'];
        //$user->profile->description = $data['description'];

        //$user->heard_about_us = $data['heard_about_us'];
        //$user->over_age_limit =  ($data['over_age_limit'] == 'on') ? 1 : 0;
        //$user->accept_terms = ($data['accept_terms'] == 'on') ? 1 : 0;

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