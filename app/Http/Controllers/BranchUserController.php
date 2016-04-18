<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class BranchUserController extends Controller
{
    /**
     * Get list branch
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getListBranches()
    {
        return Branch::all();
    }

    /**
     * See if the user is in the given branch.
     *
     * @param $userId
     * @param $branchId
     * @return bool
     */
    public static function inBranch($userId, $branchId)
    {
        $user = User::find($userId)->branches;

        foreach ($user as $_branch)
        {
            if ($_branch->id == $branchId)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Update relationships branch - user
     *
     * @param Request $request
     * @return string
     */
    public function updateBranchUser(Request $request)
    {
        $user = User::find($request->userId);
        if(count($request->branches)) {
            $user->branches()->sync($request->branches);
        } else {
            $user->branches()->detach();

        }

        $request->session()->flash('success', 'Данные успешно обновлены');

        return redirect(route('sentinel.users.index'));
    }
}
