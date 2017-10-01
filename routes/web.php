<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::get('/', function () {
    return view('auth.login');
});

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => 'web'], function () {
    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated']], function () {
    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@show',
    ]);
});

// Registered, activated, and is current user routes.
Route::group(['middleware'=> ['auth', 'activated', 'currentUser']], function () {
    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only'  => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses'      => 'ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);

    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => 'qr'], function () {
            Route::get('/scan', 'ScanController@showScan');
            Route::get('/', 'ScanController@showScan');
        });

        Route::get('/description', 'DescriptionController@showDescription');
        Route::get('/', 'DescriptionController@showDescription');
    });
});

// Registered, activated, and is admin routes.
Route::group(['middleware'=> ['auth', 'activated', 'role:admin']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::group(['prefix' => 'leader'], function () {
        Route::group(['prefix' => 'qr'], function () {
            Route::get('/generate', 'GenerateController@showGenerate');
            Route::get('/', 'GenerateController@showGenerate');
        });

        Route::get('/ranking', 'RankingController@showRanking');
        Route::get('/', 'RankingController@showRanking');
    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('php', 'AdminDetailsController@listPHPInfo');
    Route::get('routes', 'AdminDetailsController@listRoutes');
});
