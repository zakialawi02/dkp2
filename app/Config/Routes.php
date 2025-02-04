<?php

use CodeIgniter\Router\RouteCollection;

// $routes->set404Override(function () {
//     return view('404');
// });

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('dashboard', [], function ($routes) {
    $routes->group('', ['filter' => 'role:SuperAdmin,Admin'], function ($routes) {
        $routes->get('users', 'UserController::index', ['as' => 'admin.users.index']);
        $routes->post('users/store', 'UserController::store', ['as' => 'admin.users.store']);
        $routes->get('users/show/(:segment)', 'UserController::show/$1', ['as' => 'admin.users.show']);
        $routes->match(['post', 'put'], 'users/update/(:segment)', 'UserController::update/$1', ['as' => 'admin.users.update']);
        $routes->delete('users/delete/(:segment)', 'UserController::destroy/$1', ['as' => 'admin.users.destroy']);

        $routes->get('permohonan/disetujui', 'PermohonanController::permohonanDisetujui', ['as' => 'admin.permohonan.disetujui']);
        $routes->get('permohonan/tidak-disetujui', 'PermohonanController::permohonanTidakDisetujui', ['as' => 'admin.permohonan.tidakDisetujui']);
        $routes->get('permohonan/masuk', 'PermohonanController::permohonanMasuk', ['as' => 'admin.permohonan.masuk']);

        $routes->get('modul', 'ModulController::index', ['as' => 'admin.modul.index']);

        $routes->group('setting', [], function ($routes) {
            $routes->get('view-peta', 'SettingController::viewPeta', ['as' => 'admin.setting.viewPeta']);
        });

        $routes->group('kesesuaian/data', function ($routes) {
            $routes->get('kegiatan', 'KesesuaianController::kegiatan', ['as' => 'admin.kesesuaian.kegiatan']);
            $routes->post('kegiatan/create', 'KesesuaianController::tambahKegiatan', ['as' => 'admin.kesesuaian.kegiatan.create']);
            $routes->get('zona', 'KesesuaianController::zona', ['as' => 'admin.kesesuaian.zona']);
            $routes->get('kawasan', 'KesesuaianController::kawasan', ['as' => 'admin.kesesuaian.kawasan']);
            $routes->get('kawasan/show/(:any)', 'KesesuaianController::showDataKawasan/$1', ['as' => 'admin.kesesuaian.kawasan.show']);
            $routes->post('kawasan/create', 'KesesuaianController::tambahZonaKawasan', ['as' => 'admin.kesesuaian.kawasan.create']);
            $routes->match(['post', 'patch'], 'kawasan/update/(:any)', 'KesesuaianController::updateKawasan/$1', ['as' => 'admin.kesesuaian.kawasan.update']);
            $routes->delete('kawasan/delete/(:any)', 'KesesuaianController::deleteKawasan/$1', ['as' => 'admin.kesesuaian.kawasan.delete']);
            $routes->get('kesesuaian', 'KesesuaianController::kesesuaian', ['as' => 'admin.kesesuaian.kesesuaian']);
        });
    });

    $routes->group('', ['filter' => 'role:SuperAdmin,Admin,User'], function ($routes) {
        $routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);

        $routes->get('profile', 'ProfileController::index', ['as' => 'admin.profile.index']);
        $routes->match(['post', 'patch'], 'profile', 'ProfileController::update', ['as' => 'admin.profile.update']);
        $routes->match(['post', 'patch'], 'profile/photo', 'ProfileController::updatePhoto', ['as' => 'admin.profile.updatePhoto']);
        $routes->match(['post', 'patch'], 'profile/password', 'ProfileController::updatePassword', ['as' => 'admin.profile.updatePassword']);
        $routes->delete('profile/delete', 'ProfileController::destroy', ['as' => 'admin.profile.destroy']);
    });
});



$routes->get('/peta', 'KesesuaianController::petaKesesuaian', ['as' => 'petaKesesuaian']);
