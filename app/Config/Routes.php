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

        $routes->get('data/permohonan/disetujui', 'PermohonanController::permohonanDisetujui', ['as' => 'admin.permohonan.disetujui']);
        $routes->get('data/permohonan/disetujui-dengan-lampiran', 'PermohonanController::permohonanDisetujuiDgLampiran', ['as' => 'admin.permohonan.disetujuiDgLampiran']);
        $routes->get('data/permohonan/disetujui-tanpa-lampiran', 'PermohonanController::permohonanDisetujuiTnpLampiran', ['as' => 'admin.permohonan.disetujuiTnpLampiran']);
        $routes->get('data/permohonan/tidak-disetujui', 'PermohonanController::permohonanTidakDisetujui', ['as' => 'admin.permohonan.tidakDisetujui']);
        $routes->get('data/permohonan/masuk', 'PermohonanController::permohonanMasuk', ['as' => 'admin.permohonan.masuk']);
        $routes->post('data/permohonan/kirimTindakan/(:num)', 'PermohonanController::kirimTindakan/$1', ['as' => 'admin.permohonan.kirimTindakan']);

        $routes->get('modul', 'ModulController::index', ['as' => 'admin.modul.index']);
        $routes->get('modul/create', 'ModulController::create', ['as' => 'admin.modul.create']);
        $routes->post('modul/store', 'ModulController::store', ['as' => 'admin.modul.store']);
        $routes->get('modul/edit/(:segment)', 'ModulController::edit/$1', ['as' => 'admin.modul.edit']);
        $routes->match(['post', 'put'], 'modul/update/(:segment)', 'ModulController::update/$1', ['as' => 'admin.modul.update']);
        $routes->delete('modul/delete/(:segment)', 'ModulController::destroy/$1', ['as' => 'admin.modul.destroy']);

        $routes->group('setting', [], function ($routes) {
            $routes->get('view-peta', 'SettingController::viewPeta', ['as' => 'admin.setting.viewPeta']);
            $routes->post('UpdateSetting/peta', 'SettingController::updateSettingMap', ['as' => 'admin.setting.updateSettingMap']);
        });

        $routes->group('kesesuaian/data', function ($routes) {
            $routes->get('kegiatan', 'KesesuaianController::kegiatan', ['as' => 'admin.kesesuaian.kegiatan']);
            $routes->get('kegiatan/show/(:any)', 'KesesuaianController::showDataKegiatan/$1', ['as' => 'admin.kesesuaian.kegiatan.show']);
            $routes->post('kegiatan/create', 'KesesuaianController::tambahKegiatan', ['as' => 'admin.kesesuaian.kegiatan.create']);
            $routes->match(['post', 'put'], 'kegiatan/update/(:any)', 'KesesuaianController::updateKegiatan/$1', ['as' => 'admin.kesesuaian.kegiatan.update']);
            $routes->delete('kegiatan/delete/(:any)', 'KesesuaianController::deleteKegiatan/$1', ['as' => 'admin.kesesuaian.kegiatan.delete']);
            $routes->get('zona', 'KesesuaianController::zona', ['as' => 'admin.kesesuaian.zona']);
            $routes->get('kawasan', 'KesesuaianController::kawasan', ['as' => 'admin.kesesuaian.kawasan']);
            $routes->get('kawasan/show/(:any)', 'KesesuaianController::showDataKawasan/$1', ['as' => 'admin.kesesuaian.kawasan.show']);
            $routes->post('kawasan/create', 'KesesuaianController::tambahZonaKawasan', ['as' => 'admin.kesesuaian.kawasan.create']);
            $routes->match(['post', 'put'], 'kawasan/update/(:any)', 'KesesuaianController::updateKawasan/$1', ['as' => 'admin.kesesuaian.kawasan.update']);
            $routes->delete('kawasan/delete/(:any)', 'KesesuaianController::deleteKawasan/$1', ['as' => 'admin.kesesuaian.kawasan.delete']);
            $routes->get('kesesuaian', 'KesesuaianController::kesesuaian', ['as' => 'admin.kesesuaian.kesesuaian']);
            $routes->get('kesesuaian/data/(:any)', 'KesesuaianController::showKesesuaian/$1', ['as' => 'admin.kesesuaian.kesesuaian.show']);
            $routes->post('kesesuaian/tambahAturanKesesuaian/', 'KesesuaianController::tambahAturanKesesuaian', ['as' => 'admin.kesesuaian.kesesuaian.store']);
            $routes->post('kesesuaian/updateAturanKesesuaian/(:any)', 'KesesuaianController::updateAturanKesesuaian/$1', ['as' => 'admin.kesesuaian.kesesuaian.update']);
            $routes->delete('kesesuaian/delete/(:any)', 'KesesuaianController::delete_kesesuaian/$1', ['as' => 'admin.kesesuaian.kesesuaian.delete']);
        });
    });

    $routes->group('', ['filter' => 'role:SuperAdmin,Admin,User'], function ($routes) {
        $routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);

        $routes->get('profile', 'ProfileController::index', ['as' => 'admin.profile.index']);
        $routes->match(['post', 'patch'], 'profile', 'ProfileController::update', ['as' => 'admin.profile.update']);
        $routes->match(['post', 'patch'], 'profile/photo', 'ProfileController::updatePhoto', ['as' => 'admin.profile.updatePhoto']);
        $routes->match(['post', 'patch'], 'profile/password', 'ProfileController::updatePassword', ['as' => 'admin.profile.updatePassword']);
        $routes->delete('profile/delete', 'ProfileController::destroy', ['as' => 'admin.profile.destroy']);

        $routes->get('ajuan-saya', 'DashboardController::mySubmission', ['as' => 'admin.mySubmission']);

        $routes->get('data/permohonan/(:num)/edit', 'PermohonanController::edit/$1', ['as' => 'admin.permohonan.edit']);
        $routes->delete('data/permohonan/delete/(:any)', 'PermohonanController::destroy/$1', ['as' => 'admin.permohonan.destroy']);
        $routes->get('data/permohonan/(:any)/lihat/(:num)', 'PermohonanController::show/$1/$2', ['as' => 'admin.permohonan.show']);
        $routes->get('data/permohonan/lihat/(:num)', 'PermohonanController::show/$1');
    });
});

$routes->group('', ['filter' => 'role:SuperAdmin,Admin,User'], function ($routes) {
    $routes->post('data/tambahAjuan', 'PermohonanController::tambahAjuan', ['as' => 'admin.permohonan.tambahAjuan']);
});


// Cek Kesesuaian
$routes->get('/peta', 'KesesuaianController::petaKesesuaian', ['as' => 'petaKesesuaian']);
$routes->match(['get', 'post'], '/data/cekStatus', 'KesesuaianController::cekStatus', ['as' => 'data.cekStatus']);
$routes->get('/data/pengajuan', 'PermohonanController::pengajuanPermohonan', ['as' => 'data.pengajuanPermohonan']);
$routes->post('/data/isiAjuan', 'PermohonanController::isiAjuan', ['as' => 'data.isiAjuan']);

$routes->get('/data/modul', 'ModulController::indexFront', ['as' => 'modul.index']);
