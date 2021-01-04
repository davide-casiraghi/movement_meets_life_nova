<?php

namespace App\Repositories;

use App\Http\Requests\AdminStoreRequest;
use App\User;

interface UserRepositoryInterface {

    /**
     * Get all the administrators.
     *
     * @param int|null $recordsPerPage
     *
     * @param array|null $searchParameters
     *
     * @return iterable|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function administrators(int $recordsPerPage = NULL, array $searchParameters = NULL);

    /**
     * Get all the members.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return iterable|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function members(int $recordsPerPage = NULL, array $searchParameters = NULL);

    /**
     * Get user by id
     *
     * @param int $userId
     *
     * @return User
     */
    public function getById(int $userId);

    /**
     * Store Member
     *
     * @param array $data
     *
     * @return User
     */
    public function storeMember(array $data);

    /**
     * Store Admin
     *
     * @param \App\Http\Requests\AdminStoreRequest $data
     *
     * @return User
     */
    public function storeAdmin(AdminStoreRequest $data);

    /**
     * Update User
     *
     * @param \App\Http\Requests\MemberStoreRequest|\App\Http\Requests\AdminStoreRequest $data
     * @param int $userId
     *
     * @return User
     */
    public function update($data, int $userId);

    /**
     * Delete User
     *
     * @param int $userId
     *
     * @return void
     */
    public function delete(int $userId);

}