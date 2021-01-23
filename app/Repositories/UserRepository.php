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

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['name'])) {
                $query->whereHas('profile', function ($q) use ($searchParameters) {
                    $q->where('name', 'like', '%' . $searchParameters['name'] . '%');
                });
            }
            if (!empty($searchParameters['surname'])) {
                $query->whereHas('profile', function ($q) use ($searchParameters) {
                    $q->where('surname', 'like', '%' . $searchParameters['surname'] . '%');
                });
            }
            if (!empty($searchParameters['email'])) {
                $query->where('email', 'like', '%' . $searchParameters['email'] . '%');
            }
            if (!empty($searchParameters['countryId'])) {
                $query->whereHas('profile', function ($q) use ($searchParameters) {
                    $q->where('country_id', $searchParameters['countryId']);
                });
            }
            if (!empty($searchParameters['role'])) {
                $query->role($searchParameters['role']);
            }
            if (!empty($searchParameters['team'])) {
                $query->role($searchParameters['team']);
            }
        }

        if ($recordsPerPage) {
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

        $user->setStatus('enabled');

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

        $status = (isset($data['status'])) ? 'enabled' : 'disabled';
        if ($user->status() != $status) {
            $user->setStatus($status);
        }

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
