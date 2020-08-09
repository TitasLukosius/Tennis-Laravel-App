<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoRequest;
use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserInfoController extends Controller
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
        $user = UserInfo::find($user_id);
        if ($user == null) {
            return redirect()->route('user-info.create');
        }

        $table = [
            'thead' =>
                [
                    'id', 'name', 'surname', 'age', 'gender', 'city', 'NTRP', 'description', 'add'
                ],
        ];

        $table['tbody'] = [
            'name' => $user->name,
            'surname' => $user->surname,
            'age' => $user->age,
            'gender' => $user->gender,
            'city' => $user->city,
            'NTRP level' => $user->NTRP,
            'description' => $user->description,
            'Edit' => view('components/a', [
                'href' => route('user-info.edit', $user->id),
                'title' => 'Edit'
            ]),
        ];

        $photo = $user->photo;

        return view('user_info', ['table' => $table], ['photo' => $photo]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = [
            'attr' => [
                'action' => '/user-info',
                'class' => 'create-form',
                'enctype' => 'multipart/form-data'
            ],
            'fields' => [
                'photo' => [
                    'label' => 'Photo',
                    'type' => 'file'
                ],
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                ],
                'surname' => [
                    'label' => 'Surname',
                    'type' => 'text',
                ],
                'age' => [
                    'label' => 'Age',
                    'type' => 'number',
                ],
                'gender' => [
                    'label' => 'Gender',
                    'type' => 'select',
                    'value' => '',
                    'options' => [
                        'Male' => 'Male',
                        'Female' => 'Female'
                    ]
                ],
                'city' => [
                    'label' => 'City',
                    'type' => 'text'
                ],
                'NTRP' => [
                    'label' => 'NTRP level',
                    'type' => 'select',
                    'value' => '',
                    'options' => [
                        '1.0' => '1.0',
                        '1.5' => '1.5',
                        '2.0' => '2.0',
                        '2.5' => '2.5',
                        '3.0' => '3.0',
                        '3.5' => '3.5',
                        '4.0' => '4.0',
                        '4.5' => '4.5',
                        '5.0' => '5.0',
                        '5.5' => '5.5',
                        '6.0' => '6.0'
                    ]
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'text',
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserInfoRequest $request)
    {
        $userInfo = new UserInfo($request->all());
        if($userInfo->photo !== null) {
            $userInfo->photo = Storage::url(Storage::putFile('public/userInfo',$userInfo->photo));
        }
        $userInfo->save();
        return redirect('/user-info');
    }

    /**
     * Display the specified resource.
     *
     * @param UserInfo $user_info
     * @return void
     */
    public function show(UserInfo $userInfo)
    {
        dd($userInfo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UserInfo $user_info
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInfo $userInfo)
    {

        $form = [
            'attr' => [
                'action' => route('user-info.update', $userInfo->id),
                'class' => 'edit-form',
                'enctype' => 'multipart/form-data'
            ],
            'fields' => [
                '_method' => [
                    'type' => 'hidden',
                    'name' => '_method',
                    'value' => 'PUT'
                ],
                'photo' => [
                    'label' => 'Photo',
                    'type' => 'file',
                    'value' => $userInfo->photo
                ],
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'value' => $userInfo->name
                ],
                'surname' => [
                    'label' => 'Surname',
                    'type' => 'text',
                    'value' => $userInfo->surname
                ],
                'age' => [
                    'label' => 'Age',
                    'type' => 'number',
                    'value' => $userInfo->age
                ],
                'gender' => [
                    'label' => 'Gender',
                    'type' => 'select',
                    'value' => $userInfo->gender,
                    'options' => [
                        'Male' => 'Male',
                        'Female' => 'Female'
                    ]
                ],
                'city' => [
                    'label' => 'City',
                    'type' => 'text',
                    'value' => $userInfo->city
                ],
                'NTRP' => [
                    'label' => 'NTRP level',
                    'type' => 'select',
                    'value' => $userInfo->NTRP,
                    'options' => [
                        '1.0' => '1.0',
                        '1.5' => '1.5',
                        '2.0' => '2.0',
                        '2.5' => '2.5',
                        '3.0' => '3.0',
                        '3.5' => '3.5',
                        '4.0' => '4.0',
                        '4.5' => '4.5',
                        '5.0' => '5.0',
                        '5.5' => '5.5',
                        '6.0' => '6.0'
                    ]
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'text',
                    'value' => $userInfo->description
                ],
            ],
            'buttons' => [
                'submit' => [
                    'text' => 'Edit',
                    'name' => 'action',
                ],
            ],
        ];

        return view('edit_user_info', ['form' => $form]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param UserInfo $user_info
     * @return void
     */
    public function update(UserInfoRequest $request, $id)
    {

        $userInfo = UserInfo::find($id);
        $userInfo->photo = $request->input('photo');
        $userInfo->photo = Storage::url(Storage::putFile('public/userInfo',$request->photo));
        $userInfo->name = $request->input('name');
        $userInfo->surname = $request->input('surname');
        $userInfo->age = $request->input('age');
        $userInfo->gender = $request->input('gender');
        $userInfo->city = $request->input('city');
        $userInfo->NTRP = $request->input('NTRP');
        $userInfo->description = $request->input('description');
        $userInfo->save();

        return redirect()->route('user-info.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserInfo $userInfo
     * @return void
     */
    public function destroy(UserInfo $userInfo)
    {
        //
    }
}
