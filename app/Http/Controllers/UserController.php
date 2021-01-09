<?php

namespace App\Http\Controllers;

use App\Exports\MembersExport;
use App\Exports\ReportsExport;
use App\Http\Requests\MemberSearchRequest;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\UserStoreRequest;
use App\Notifications\MemberResetPasswordNotification;
use App\Repositories\GenderRepositoryInterface;
use App\Repositories\HeardAboutUsRepositoryInterface;
use App\Repositories\RegionRepositoryInterface;
use App\Repositories\WorkTypeRepositoryInterface;
use App\Services\CountryService;
use App\Services\NoteService;
use App\Services\MemberService;
use App\Services\RegionService;
use App\Services\TeamService;
use App\Services\UserService;

use App\Traits\CheckPermission;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class UserController extends Controller
{
    use CheckPermission;

    private UserService $userService;
    private TeamService $teamService;
    private CountryService $countryService;

    /**
     * UserController constructor.
     *
     * @param \App\Services\UserService $userService
     * @param \App\Services\TeamService $teamService
     * @param \App\Services\CountryService $countryService
     */
    public function __construct(
        UserService $userService,
        TeamService $teamService,
        CountryService $countryService
    )
    {
        $this->userService = $userService;
        $this->teamService = $teamService;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the users.
     *
     * @param \App\Http\Requests\UserSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(UserSearchRequest $request)
    {
        $this->checkPermission('users.view');

        $searchParameters = $this->userService->getSearchParameters($request);
        $users = $this->userService->getUsers(20, $searchParameters);
        $roles = $this->teamService->getAllUserRoles();
        $countries = $this->countryService->getCountries();

        return view('users.index', [
            'users' => $users,
            'roles' => $roles,
            'countries' => $countries,
            'searchParameters' =>$searchParameters,
        ]);
    }

    /**
     * Show to the form for creating a new user.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create()
    {
        $this->checkPermission('users.create');

        $countries = $this->countryService->getCountries();
        $roles = $this->teamService->getAllUserRoles();

        return view('users.create', [
            'countries' => $countries,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a user created by an admin
     *
     * @param \App\Http\Requests\UserStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request)
    {
        $this->checkPermission('users.create');

        $data = $request->all();

        $user = $this->memberService->createMember($data);
        $user->notify(new MemberResetPasswordNotification($user));

        return redirect()->route('members.index')
            ->with('success', 'Member created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $userId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(int $userId)
    {
        if (Auth::id() != $userId){
            $this->checkPermission('users.edit');
        }

        $user = $this->userService->getById($userId);
        $countries = $this->countryService->getCountries();
        $roles = $this->teamService->getAllUserRoles();

        return view('users.edit', [
            'user' => $user,
            'countries' => $countries,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserStoreRequest $request
     * @param  int  $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserStoreRequest $request, int $userId)
    {
        if (Auth::id() != $userId){
            $this->checkPermission('users.edit');
        }

        $this->userService->updateMember($request, $userId);

        if(Auth::user()->hasPermissionTo('users.edit')){
            return redirect()->route('users.index')
                ->with('success', __('ui.users.admin_updated_member_profile'));
        }
        if(Session::get('completeProfile')){
            return redirect()->back()
                ->with('success', __('ui.users.first_time_updated_profile'));
        }
        return redirect()->back()
            ->with('success', __('ui.users.updated_profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $userId)
    {
        $this->checkPermission('users.delete');

        $this->userService->deleteMember($userId);

        return redirect()->route('users.index')
            ->with('success', __('ui.users.admin_deleted_member_profile'));
    }

    /**
     * Show to the user a notice that his/her status is still pending
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function pending()
    {
        return view('users.status.pending');
    }

    /**
     * Show to the user a notice that his/her status is refused
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function refused()
    {
        return view('users.status.refused');
    }



}
