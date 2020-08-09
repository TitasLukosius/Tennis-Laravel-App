<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Invitation;
use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();
        $invitations = Invitation::all()->sortBy('id');

        $table = [
            'thead' =>
                [
                    'inviter', 'accepter','match time', 'match place',
                ],
        ];

        foreach ($invitations as $invitation)
        {
            if($invitation->from_user_id == $user_id || $invitation->to_user_id == $user_id) {
                if($invitation->status == 'accepted') {
                    $usersInfo1 = UserInfo::where('id', $invitation->to_user_id)->get();
                    $usersInfo2 = UserInfo::where('id', $invitation->from_user_id)->get();
                    $table['tbody'][] = [
                        'inviter' => $usersInfo2[0]->name,
                        'accepter' => $usersInfo1[0]->name,
                        'game_time' => $invitation->date_time,
                        'game_place' => $invitation->place,
                    ];
                }
            }
        }

        return view('matches', ['table' => $table]);
    }

}
