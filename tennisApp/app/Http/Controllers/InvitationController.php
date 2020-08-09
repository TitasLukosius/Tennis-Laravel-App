<?php

namespace App\Http\Controllers;

use App\Invitation;
use App\User;
use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $sent_invitations = Invitation::where('from_user_id', $user_id)->get();
        $recieved_invitations = Invitation::where('to_user_id', $user_id)->get();
        $table = [
            'thead' =>
                [
                    'name', 'surname', 'NTRP', 'time', 'place', 'status', 'cancel invitation'
                ],
        ];

        $tableB = [
            'thead' => [
                'name', 'surname', 'NTRP', 'time', 'place', 'players profile', 'accept', 'decline'
            ]
        ];
        foreach ($sent_invitations as $invitation) {
            $usersInfo = UserInfo::where('id', $invitation->to_user_id)->get();
            $table['tbody'][] = [
                'name' => $usersInfo[0]->name,
                'surname' => $usersInfo[0]->surname,
                'NTRP' => $usersInfo[0]->NTRP,
                'time' => $invitation->date_time,
                'place' => $invitation->place,
                'status' => $invitation->status,
                'cancel' => view('components/form', [
                    'attr' => [
                        'action' => route('invitations.destroy', $invitation->id)
                    ],
                    'fields' => [
                        '_method' => [
                            'type' => 'hidden',
                            'value' => 'DELETE'
                        ]
                    ],
                    'buttons' => [
                        'delete' => [
                            'text' => 'Cancel invitation'
                        ]
                    ]
                ]),
            ];
        }

        foreach ($recieved_invitations as $invitation) {
            $usersInfo = UserInfo::where('id', $invitation->from_user_id)->get();
            if ($invitation->status == 'pending') {
                $tableB['tbody'][] = [
                    'name' => $usersInfo[0]->name,
                    'surname' => $usersInfo[0]->surname,
                    'NTRP' => $usersInfo[0]->NTRP,
                    'time' => $invitation->date_time,
                    'place' => $invitation->place,
                    'profile' => view('components/a', [
                        'href' => route('users-info.show', $usersInfo[0]->id),
                        'title' => 'Visit Profile'
                    ]),
                    'accept' => view('components/a', [
                        'href' => route('invitations.acceptInvitation', $invitation->id),
                        'title' => 'Accept'
                    ]),
                    'decline' => view('components/a', [
                        'href' => route('invitations.declineInvitation', $invitation->id),
                        'title' => 'Decline'
                    ]),
                ];
            }
        }

        return view('sent_invitations', ['table' => $table], ['tableB' => $tableB]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('pasiekei');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request->all());
        $date = $request->date;
        $time = $request->time;
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date, $time"));

        $invitation = new Invitation();
        $invitation->from_user_id = $request->user_from;
        $invitation->to_user_id = $request->user_to;
        $invitation->date_time = $combinedDT;
        $invitation->place = $request->place;
        $invitation->save();

        return redirect()->route('users-info.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Invitation $invitation
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Invitation $invitation
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Invitation $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Invitation $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {

        $invitation->delete();
        return redirect()->route('invitations.index');
    }

    public function acceptInvitation(Invitation $invitation)
    {
        $invitation->status = 'accepted';
        $invitation->update();

        return redirect()->route('invitations.index');
    }

    public function declineInvitation(Invitation $invitation)
    {
        $invitation->status = 'declined';
        $invitation->update();

        return redirect()->route('invitations.index');
    }
}
