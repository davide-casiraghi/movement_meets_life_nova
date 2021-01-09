<?php

namespace App\Services;

use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class UserService {

    private UserRepositoryInterface $userRepository;
    private UserProfileRepositoryInterface $userProfileRepository;

    /**
     * AdminService constructor.
     *
     * @param \App\Repositories\UserRepositoryInterface $userRepository
     * @param \App\Repositories\UserProfileRepositoryInterface $userProfileRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserProfileRepositoryInterface $userProfileRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * Create an user and the profile at the same time
     *
     * @param \App\Http\Requests\UserStoreRequest $data
     *
     * @return User
     */
    public function createUser(UserStoreRequest $data): User
    {
        $user = $this->userRepository->storeMember($data);

        // Assign an new empty user profile to the user
        $this->userProfileRepository->store([
            'user_id' => $user->id,
            'name' => $data['name'],
            'surname' => $data['surname'],
            'phone' => $data['phone'],
        ]);

        // Teams membership
        $roles = $data['team_membership'];

        // User level
        $roles[] = $data['role'];

        $user->assignRole($roles);

        return $user;
    }

    /**
     * Update the user user and profile at the same time
     *
     * @param \App\Http\Requests\UserStoreRequest $data
     * @param int $userId
     *
     * @return User
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function updateUser(UserStoreRequest $data, int $userId): User
    {
        $user = $this->userRepository->update($data->all(), $userId);
        $this->userProfileRepository->update($data->all(), $user->profile->id);

        $roles = [];

        // User level
        $roles[] = $data['role'];

        // Teams membership
        // (Just if the role is admin, for super admins we don't need them)
        if($data['role'] == "Admin"){
            $roles[] = $data['team_membership'];
        }
        $user->syncRoles($roles);

        return $user;
    }

    /**
     * Return the user from the database
     *
     * @param int $userId
     *
     * @return User
     */
    public function getById(int $userId): User {
        return $this->userRepository->getById($userId);
    }

    /**
     * Get all the administrators.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return iterable
     */
    public function getUsers(int $recordsPerPage = null, array $searchParameters = null): iterable
    {
        return $this->userRepository->users($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the admin from the database
     *
     * @param int $userId
     */
    public function deleteAdmin(int $userId): void
    {
        $this->userRepository->delete($userId);
    }

    /**
     * Get the member search parameters
     *
     * @param \App\Http\Requests\UserSearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(UserSearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['username'] = $request->username ?? null;
        $searchParameters['email'] = $request->email ?? null;
        $searchParameters['userLevel'] = $request->userLevel ?? null;
        $searchParameters['team'] = $request->team ?? null;

        return $searchParameters;
    }

}