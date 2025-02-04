<?php

namespace Myth\Auth\Language\id;

return [
    // Exceptions
    'invalidModel'        => 'Model {0} harus dimuat sebelum digunakan.',
    'userNotFound'        => 'Tidak dapat menemukan pengguna dengan ID = {0, number}.',
    'noUserEntity'        => 'Entitas Pengguna harus disediakan untuk validasi kata sandi.',
    'tooManyCredentials'  => 'Anda hanya dapat memvalidasi 1 kredensial selain kata sandi.',
    'invalidFields'       => 'Kolom "{0}" tidak dapat digunakan untuk memvalidasi kredensial.',
    'unsetPasswordLength' => 'Anda harus mengatur pengaturan `minimumPasswordLength` di file konfigurasi Auth.',
    'unknownError'        => 'Maaf, kami mengalami masalah saat mengirimkan email kepada Anda. Silakan coba lagi nanti.',
    'notLoggedIn'         => 'Anda harus masuk untuk mengakses halaman tersebut.',
    'notEnoughPrivilege'  => 'Anda tidak memiliki izin yang cukup untuk mengakses halaman tersebut.',

    // Registration
    'registerDisabled' => 'Maaf, pendaftaran akun baru tidak diperbolehkan saat ini.',
    'registerSuccess'  => 'Selamat datang! Silakan masuk dengan kredensial baru Anda.',
    'registerCLI'      => 'Pengguna baru dibuat: {0}, #{1}',

    // Activation
    'activationNoUser'       => 'Tidak dapat menemukan pengguna dengan kode aktivasi tersebut.',
    'activationSubject'      => 'Aktifkan akun Anda',
    'activationSuccess'      => 'Harap konfirmasi akun Anda dengan mengklik tautan aktivasi di email yang kami kirimkan.',
    'activationResend'       => 'Kirim ulang pesan aktivasi sekali lagi.',
    'notActivated'           => 'Akun pengguna ini belum diaktifkan.',
    'errorSendingActivation' => 'Gagal mengirim pesan aktivasi ke: {0}',

    // Login
    'badAttempt'      => 'Tidak dapat masuk. Silakan periksa kredensial Anda.',
    'loginSuccess'    => 'Selamat datang kembali!',
    'invalidPassword' => 'Tidak dapat masuk. Silakan periksa kata sandi Anda.',

    // Forgotten Passwords
    'forgotDisabled'  => 'Opsi pengaturan ulang kata sandi telah dinonaktifkan.',
    'forgotNoUser'    => 'Tidak dapat menemukan pengguna dengan email tersebut.',
    'forgotSubject'   => 'Instruksi Pengaturan Ulang Kata Sandi',
    'resetSuccess'    => 'Kata sandi Anda berhasil diubah. Silakan masuk dengan kata sandi baru.',
    'forgotEmailSent' => 'Token keamanan telah dikirimkan ke email Anda. Masukkan di kotak di bawah untuk melanjutkan.',
    'errorEmailSent'  => 'Tidak dapat mengirim email dengan instruksi pengaturan ulang kata sandi ke: {0}',
    'errorResetting'  => 'Tidak dapat mengirim instruksi pengaturan ulang ke {0}',

    // Passwords
    'errorPasswordLength'         => 'Kata sandi harus setidaknya {0, number} karakter.',
    'suggestPasswordLength'       => 'Frasa sandi - hingga 255 karakter - membuat kata sandi lebih aman dan mudah diingat.',
    'errorPasswordCommon'         => 'Kata sandi tidak boleh kata sandi yang umum.',
    'suggestPasswordCommon'       => 'Kata sandi diperiksa terhadap lebih dari 65 ribu kata sandi yang umum digunakan atau yang telah bocor.',
    'errorPasswordPersonal'       => 'Kata sandi tidak boleh mengandung informasi pribadi yang di-hash ulang.',
    'suggestPasswordPersonal'     => 'Variasi dari alamat email atau nama pengguna Anda tidak boleh digunakan sebagai kata sandi.',
    'errorPasswordTooSimilar'     => 'Kata sandi terlalu mirip dengan nama pengguna.',
    'suggestPasswordTooSimilar'   => 'Jangan gunakan bagian dari nama pengguna Anda dalam kata sandi.',
    'errorPasswordPwned'          => 'Kata sandi {0} telah terekspos karena pelanggaran data dan telah ditemukan {1, number} kali di {2} basis data.',
    'suggestPasswordPwned'        => '{0} tidak boleh digunakan sebagai kata sandi. Jika Anda menggunakannya di tempat lain, segera ubah.',
    'errorPasswordPwnedDatabase'  => 'sebuah basis data',
    'errorPasswordPwnedDatabases' => 'basis data',
    'errorPasswordEmpty'          => 'Kata sandi diperlukan.',
    'passwordChangeSuccess'       => 'Kata sandi berhasil diubah',
    'userDoesNotExist'            => 'Kata sandi tidak diubah. Pengguna tidak ada',
    'resetTokenExpired'           => 'Maaf. Token pengaturan ulang Anda telah kedaluwarsa.',

    // Groups
    'groupNotFound' => 'Tidak dapat menemukan grup: {0}.',

    // Permissions
    'permissionNotFound' => 'Tidak dapat menemukan izin: {0}',

    // Banned
    'userIsBanned' => 'Pengguna telah diblokir. Hubungi administrator',

    // Too many requests
    'tooManyRequests' => 'Terlalu banyak permintaan. Silakan tunggu {0, number} detik.',

    // Login views
    'home'                      => 'Beranda',
    'current'                   => 'Saat ini',
    'forgotPasswordTitle'       => 'Lupa Kata Sandi',
    'forgotPassword'            => 'Lupa Kata Sandi?',
    'enterEmailForInstructions' => 'Tidak masalah! Masukkan email Anda di bawah ini dan kami akan mengirimkan instruksi untuk mengatur ulang kata sandi Anda.',
    'email'                     => 'Email',
    'emailAddress'              => 'Alamat Email',
    'sendInstructions'          => 'Kirim Instruksi',
    'loginTitle'                => 'Masuk',
    'loginTitleDesc'            => 'Masuk ke Akun Anda',
    'loginGreeting'             => 'Masukkan nama pengguna & kata sandi Anda untuk masuk',
    'registerTitle'             => 'Daftar',
    'registerTitleDesc'         => 'Buat akun baru',
    'loginAction'               => 'Masuk',
    'rememberMe'                => 'Ingat Saya',
    'needAnAccount'             => 'Butuh akun?',
    'forgotYourPassword'        => 'Lupa kata sandi Anda?',
    'password'                  => 'Kata Sandi',
    'passwordConfirm'           => 'Konfirmasi Kata Sandi',
    'repeatPassword'            => 'Ulangi Kata Sandi',
    'name'                      => 'Nama',
    'emailOrUsername'           => 'Email atau Nama Pengguna',
    'username'                  => 'Nama Pengguna',
    'register'                  => 'Daftar',
    'signIn'                    => 'Masuk',
    'createAccount'             => 'Buat akun',
    'alreadyRegistered'         => 'Sudah terdaftar?',
    'weNeverShare'              => 'Kami tidak akan pernah membagikan email Anda dengan orang lain.',
    'resetYourPassword'         => 'Atur Ulang Kata Sandi Anda',
    'enterCodeEmailPassword'    => 'Masukkan kode yang Anda terima melalui email, alamat email Anda, dan kata sandi baru Anda.',
    'token'                     => 'Token',
    'newPassword'               => 'Kata Sandi Baru',
    'newPasswordRepeat'         => 'Ulangi Kata Sandi Baru',
    'resetPassword'             => 'Atur Ulang Kata Sandi',
];
