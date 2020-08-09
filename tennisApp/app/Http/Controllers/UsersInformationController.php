<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoRequest;
use App\Invitation;
use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersInformationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['filterPlayers']]);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $user_id = Auth::id();
//        $usersInfo = UserInfo::all()->sortBy('id');
//
//        $form = [
//            'attr' => [
//                'action' => route('users-info.filterPlayers'),
//            ],
//            'fields' => [
//                '_method' => [
//                    'type' => 'hidden',
//                    'value' => 'GET'
//                ],
//                'city' => [
//                    'label' => 'City',
//                    'type' => 'text',
//                    'value' => '',
//                    'extra' => [
//                        'attr' => [
//                            'placeholder' => 'pvz.: Vilnius'
//                        ]
//                    ],
//                ],
//            ],
//            'buttons' => [
//                'submit' => [
//                    'text' => 'Submit',
//                    'name' => 'action',
//                ],
//            ],
//        ];
//
//        $table = [
//            'thead' =>
//                [
//                     'name', 'surname', 'city', 'NTRP', '', ''
//                ],
//        ];
//
//        foreach ($usersInfo as $user) {
//            if ($user_id != $user->id) {
//                $table['tbody'][] = [
//                    'name' => $user->name,
//                    'surname' => $user->surname,
//                    'city' => $user->city,
//                    'NTRP level' => $user->NTRP,
//                    'View' => view('components/a', [
//                        'href' => route('users-info.show', $user->id),
//                        'title' => 'Visit Profile'
//                    ]),
//                    'Invite' => view('components/a', [
//                        'href' => route('users-info.sendInvitation', $user->id),
//                        'title' => 'Invite'
//                    ]),
//                ];
//            }
//        }

        return view('info');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param UserInfo $userInfo
     * @return \Illuminate\Http\Response
     */
    public function show(UserInfo $usersInfo)
    {

        $form = [
//            'attr' => [
//                'action' => route('users-info')
//            ],
            'fields' => [
                'name' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'value' => $usersInfo->name
                ],
                'surname' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'value' => $usersInfo->surname
                ],
                'age' => [
                    'label' => 'Title',
                    'type' => 'number',
                    'value' => $usersInfo->age
                ],
                'gender' => [
                    'label' => 'Title',
                    'type' => 'select',
                    'value' => $usersInfo->gender,
                    'options' => [
                        'Male',
                        'Female'
                    ]
                ],
                'city' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'value' => $usersInfo->city
                ],
                'NTRP' => [
                    'label' => 'Title',
                    'type' => 'select',
                    'value' => $usersInfo->NTRP,
                    'options' => [
                        '1.0',
                        '1.5',
                        '2.0',
                        '2.5',
                        '3.0',
                        '3.5',
                        '4.0',
                        '4.5',
                        '5.0',
                        '5.5',
                        '6.0'
                    ]
                ],
                'description' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'value' => $usersInfo->description
                ],
            ],
        ];

        return view('all_users', ['form' => $form], ['photo' => $usersInfo->photo]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInfo $userInfo)
    {
        dd('suds');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendInvitation(UserInfo $usersInfo)
    {

        $from_user = Auth::id();
        $to_user = $usersInfo->id;

        $form = [
            'attr' => [
                'action' => route('invitations.store'),
                'class' => 'invite-page'
            ],
            'fields' => [
                'user_to' => [
                    'value' => $to_user,
                    'type' => 'hidden',
                ],
                'user_from' => [
                    'type' => 'hidden',
                    'value' => $from_user
                ],
                'date' => [
                    'label' => 'Enter match date',
                    'type' => 'date',
                ],
                'time' => [
                    'label' => 'Enter match time',
                    'type' => 'time',
                ],
                'place' => [
                    'label' => 'Enter match place',
                    'type' => 'text'
                ],
            ],
            'buttons' => [
                'submit' => [
                    'text' => 'Submit',
                    'name' => 'action',
                ],
            ],
        ];

        return view('create_user_info', ['form' => $form]);
    }

    public function filterPlayers(Request $request)
    {
        //$request yra vue js duomenys is formos
//jeigu tuscia visus atiduoda, t.y getAll metodas
        if ($request->search === null) {
            $usersAll = UserInfo::all()->except(Auth::id());
            return $usersAll;
        } else {
//jei netuscia iesko duomenu bazei pagal nurodytus dalykus
            return UserInfo::where('city', $request->search)
                ->orWhere('city', 'like', '%' . $request->search . '%')->get()->except(Auth::id());
        }
    }
}
