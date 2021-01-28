<?php

namespace App\Policies;

use App\Tutorial;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TutorialPolicy
{
    use HandlesAuthorization;
    public function before($user, $ability)
    {
        if ($user->isGranted(User::ROLE_SUPERADMIN)) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any tutorials.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isGranted(User::ROLE_STUDENT);

    }

    /**
     * Determine whether the user can view the tutorial.
     *
     * @param  \App\User  $user
     * @param  \App\Tutorial  $tutorial
     * @return mixed
     */
    public function view(User $user, Tutorial $tutorial)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    /**
     * Determine whether the user can create tutorials.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    /**
     * Determine whether the user can update the tutorial.
     *
     * @param  \App\User  $user
     * @param  \App\Tutorial  $tutorial
     * @return mixed
     */
    public function update(User $user, Tutorial $tutorial)
    {
        return $user->isGranted(User::ROLE_STUDENT) && $user->id;

    }

    public function choose(User $user, Tutorial $tutorial){

        if($tutorial->teacher_id===null){
            return $user->isGranted(User::ROLE_TEACHER) && $user->id ;
        }

    }
    /**
     * Determine whether the user can delete the tutorial.
     *
     * @param  \App\User  $user
     * @param  \App\Tutorial  $tutorial
     * @return mixed
     */
    public function delete(User $user, Tutorial $tutorial)
    {
        //
    }

    /**
     * Determine whether the user can restore the tutorial.
     *
     * @param  \App\User  $user
     * @param  \App\Tutorial  $tutorial
     * @return mixed
     */
    public function restore(User $user, Tutorial $tutorial)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the tutorial.
     *
     * @param  \App\User  $user
     * @param  \App\Tutorial  $tutorial
     * @return mixed
     */
    public function forceDelete(User $user, Tutorial $tutorial)
    {
        //
    }
}
