<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\{
    HomeController,
    JobController,
    UserController,
    AssetController,
    ProcessingJobController,
    NotificationController,
    DepartmentController,
};



Route::view('/test', 'welcome');

Route::middleware('CheckIfAuthenticated')->group(function()
{
    Route::get('/get-notification', [NotificationController::class,'get_notif'])->name('get_notification');
    Route::get('/get-notification-count', [NotificationController::class,'get_count'])->name('get_notification_count');


    Route::get('/', [HomeController::class,'home'])->name('home');
    Route::get('auth/logout', [AuthController::class,'logout'])->name('auth.logout');


    Route::put('/user/{user}/update-password', [UserController::class,'update_password'])->name('user.update_password');
    Route::put('/user/{user}/loggout-all-other-sessions', [UserController::class,'loggout_all_other_sessions'])->name('user.loggout_all_other_sessions');
    Route::resource('/user', UserController::class);

    
    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function(){
        Route::get('/', [HomeController::class,'admin'])->name('home');


        Route::get('/getNotif/notif', [AssetController::class,'notif'])->name('notif');


        Route::post('/user/massDelete', [UserController::class, 'massDelete'])->name('user.massDelete');
        Route::get('/user/massEdit', [UserController::class, 'massEdit'])->name('user.massEdit');
        Route::post('/user/massUpdate', [UserController::class, 'massUpdate'])->name('user.massUpdate');

        
        Route::post('/asset/massDelete', [AssetController::class, 'massDelete'])->name('asset.massDelete');
        Route::get('/asset/massEdit', [AssetController::class, 'massEdit'])->name('asset.massEdit');
        Route::post('/asset/massUpdate', [AssetController::class, 'massUpdate'])->name('asset.massUpdate');
        Route::resource('/asset', AssetController::class);

        
        Route::post('/department/massDelete', [DepartmentController::class, 'massDelete'])->name('department.massDelete');
        Route::get('/department/massEdit', [DepartmentController::class, 'massEdit'])->name('department.massEdit');
        Route::post('/department/massUpdate', [DepartmentController::class, 'massUpdate'])->name('department.massUpdate');
        Route::resource('/department', DepartmentController::class);


        Route::post('/job/massDelete', [JobController::class, 'massDelete'])->name('job.massDelete');
        Route::get('/job/massEdit', [JobController::class, 'massEdit'])->name('job.massEdit');
        Route::post('/job/massUpdate', [JobController::class, 'massUpdate'])->name('job.massUpdate');
        Route::get('/job', [JobController::class, 'admin_index'])->name('job.index');
        Route::resource('/job', JobController::class)->except(['index']);
    });


    Route::group(['middleware' => 'role:employee', 'prefix' => 'employee', 'as' => 'employee.'], function(){
        Route::get('/', [HomeController::class,'employee'])->name('home');
              
        Route::resource('/asset', AssetController::class)->only(['index', 'show']);

        
        Route::get('/job/verify/{job}', [JobController::class, 'verify'])->name('job.verify');
        Route::resource('/job', JobController::class);
    });


    Route::group(['middleware' => 'role:mis_office_personnel', 'prefix' => 'MIS_Office', 'as' => 'mis_office_personnel.'], function(){
        Route::get('/', [HomeController::class,'MIS_Office'])->name('home');
        
        Route::resource('/asset', AssetController::class)->only(['index', 'show']);

        
        Route::get('/job', [ProcessingJobController::class, 'index'])->name('job.index');
        Route::get('/job/show/{job}/{user}', [ProcessingJobController::class, 'show'])->name('job.show');
        Route::post('/job/action', [ProcessingJobController::class, 'action'])->name('job.action');
        Route::post('/job/done', [ProcessingJobController::class, 'done'])->name('job.done');
    });


    Route::group(['middleware' => 'role:supply_office_personnel', 'prefix' => 'Supply_Office', 'as' => 'supply_office_personnel.'], function(){
        Route::get('/', [HomeController::class,'Supply_Office'])->name('home');
        
        Route::post('/asset/massDelete', [AssetController::class, 'massDelete'])->name('asset.massDelete');
        Route::post('/asset/massUpdate', [AssetController::class, 'massUpdate'])->name('asset.massUpdate');
        Route::resource('/asset', AssetController::class);

        
        Route::resource('/job', JobController::class);
    });
});



Route::middleware('CheckIfNotAuthenticated')->group(function()
{
    Route::get('/auth/login-view', [AuthController::class,'view_login'])->name('auth.login.view');

    Route::post('auth/login', [AuthController::class,'login'])->name('auth.login');
});
