<?php
namespace App\Traits;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Illuminate\Support\Facades\Auth;

trait CheckPermission
{
    public function checkPermission(string $permissionName)
    {
        if (!Auth::user()->hasPermissionTo($permissionName)) {
            throw new AccessDeniedException("You have not the permission to view this page", 403);
        }
    }

    public function checkPermissionAllowOwner(string $permissionName, $entity)
    {
        if (!( Auth::user()->hasPermissionTo($permissionName) || Auth::id() === $entity->user_id)) {
            throw new AccessDeniedException("You have not the permission to view this page", 403);
        }
    }



}