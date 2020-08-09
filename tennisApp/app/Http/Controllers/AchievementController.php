<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Http\Requests\AchievementRequest;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */

    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index()
    {

        $achievements = Achievement::all()->sortBy('id');
        $table = [
            'thead' =>
                [
                    'id', 'title', 'description', 'points', 'edit', 'delete'
                ],
        ];

        foreach ($achievements as $achievement) {
            $table['tbody'][] = [
                $achievement->id,
                $achievement->title,
                $achievement->description,
                $achievement->points,
                view('components/a', [
                    'href' => route('achievements.edit', $achievement->id),
                    'title' => 'edit'
                ]),
                view('components/form',
                    [
                        'attr' => [
                            'action' => route('achievements.destroy', $achievement->id),
                        ],
                        'fields' => [
                            '_method' => [
                                'type' => 'hidden',
                                'value' => 'DELETE'
                            ]
                        ],
                        'buttons' => [
                            'edit' => [
                                'text' => 'Delete'
                            ]
                        ]])
            ];
        }

        return view('achievements', ['table' => $table]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * //   * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        $form = [
            'attr' => [
                'action' => '/achievements'
            ],
            'fields' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'text',
                ],
                'points' => [
                    'label' => 'Points',
                    'type' => 'number',
                ],
                'select' => [
                    'extra' => [
                        'attr' => [
                            'multiple' => true
                        ]
                    ],
                    'label' => 'Select',
                    'type' => 'select',
                    'value' => '',
                    'options' => [
                    ]
                ],
            ],
            'buttons' => [
                'send' => [
                    'text' => 'Submit',
                    'name' => 'action',
                ],
            ],
        ];

        foreach ($users as $user) {
            $form['fields']['select']['options'][$user->id] = $user->name;
        }

        return view('create_achievements', ['form' => $form]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(AchievementRequest $request)
    {
        $achievement = new Achievement($request->all());
        $achievement->save();
        $achievement->users()->attach($request->input('select'));

        return redirect('/achievements');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function show(Achievement $achievement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function edit(Achievement $achievement)
    {
        $users = User::all();

        $selected_users = $achievement->users()->get();

        $form = [
            'attr' => [
                'action' => route('achievements.update', $achievement->id)
            ],
            'fields' => [
                '_method' => [
                    'type' => 'hidden',
                    'name' => '_method',
                    'value' => 'PUT'
                ],
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'value' => $achievement->title
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'text',
                    'value' => $achievement->description
                ],
                'points' => [
                    'label' => 'Points',
                    'type' => 'number',
                    'value' => $achievement->points
                ],
                'select' => [
                    'extra' => [
                        'attr' => [
                            'multiple' => true,
                        ]
                    ],
                    'label' => 'Select',
                    'type' => 'select',
                    'value' => [],
                    'options' => [
                    ]
                ]
            ],
            'buttons' => [
                'send' => [
                    'text' => 'Edit',
                    'name' => 'action',
                ],
            ],
        ];

        foreach ($users as $user) {
            $form['fields']['select']['options'][$user->id] = $user->name;
        }

        foreach ($selected_users as $user) {
            $id = $user->pivot->user_id;
            $form['fields']['select']['value'][] = $id;
        }

        return view('edit_achievements', ['form' => $form]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(AchievementRequest $request, Achievement $achievement)
    {

        $achievement->title = $request->input('title');
        $achievement->description = $request->input('description');
        $achievement->points = $request->input('points');
        $achievement->save();

        $achievement->users()->sync($request->input('select'));

        return redirect('/achievements');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return redirect()->route('achievements.index');
    }
}
