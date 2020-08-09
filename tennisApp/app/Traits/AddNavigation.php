<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

trait AddNavigation
{

    public function addNavigation()
    {

        $this->middleware(function ($request, $next) {

            $nav = [
                'left' => [
                    'links' => [
                        [
                            'url' => url('/users-info'),
                            'name' => 'Players'
                        ],
                        [
                            'url' => url('/invitations'),
                            'name' => 'Invitations'
                        ],
                        [
                            'url' => url('/matches'),
                            'name' => 'Upcoming Matches'
                        ],

                    ]
                ],
            ];

            if (Auth::user()) {
                $nav['right']['dropdown'] = [
                    [
                        'url' => route('user-info.index'),
                        'name' => 'My info'
                    ],
                    [
                        'url' => route('logout'),
                        'name' => 'Logout',
                    ],
                ];
            } else {
                $nav['right']['links'] = [
                    [
                        'url' => route('login'),
                        'name' => 'Login'
                    ],
                ];
                if (Route::has('register')) {
                    $nav['right']['links'][] =
                        [
                            'url' => route('register'),
                            'name' => 'Register'
                        ];
                }
            }

            View::share('nav', $nav);
            return $next($request);
        });
    }
}
