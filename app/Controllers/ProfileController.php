<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Password;

class ProfileController extends BaseController
{
    protected $users;
    protected $auth;
    /**
     * @var AuthConfig
     */
    protected $config;
    /**
     * @var Session
     */
    protected $session;
    public function __construct()
    {
        $this->users = new UserModel();
        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth   = service('authentication');
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')
            ->select('users.id as user_id, users.user_image, users.username, users.email, users.full_name, auth_groups.name as role')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->where('users.id', user()->id)
            ->get()->getRowArray();

        $data = [
            'title' => 'Profile',
            'profile' => $user,
        ];

        return view('Pages/dashboard/profile/index', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update()
    {
        $request = $this->request->getPost();

        if (user()->email !== $this->request->getPost(['email'])) {
            $request['active_hash'] =  null;
        }

        $this->users->update(user()->id, $request);

        return redirect()->back()
            ->with('status', 'profile-updated')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto()
    {
        $photo = $this->request->getFile('photo_profile');
        if ($photo->isValid() && !$photo->hasMoved()) {
            $name = $photo->getRandomName();
            $uploadFoto = $name;
            if (user()->user_image !== "admin.jpg" && user()->user_image !== "user.jpg") {
                $old_photo = 'assets/img/profile/' . user()->user_image;
                if (file_exists($old_photo)) {
                    unlink($old_photo);
                }
            }
            try {
                // Image manipulation(compress)
                $image = \Config\Services::image()
                    ->withFile($photo)
                    ->fit(1000, 1000, 'center')
                    ->save(FCPATH . 'assets/img/profile/' . $uploadFoto);
                $data['user_image'] = $uploadFoto;
            } catch (\Throwable $th) {
                //throw $th;
                $image = \Config\Services::image()
                    ->save(FCPATH . 'assets/img/profile/' . $uploadFoto);
                $data['user_image'] = $uploadFoto;
            }
            $this->users->skipValidation(true);
            $this->users->update(user()->id, $data);
            return redirect()->back()
                ->with('status', 'photo-updated')
                ->with('success', 'Photo profile updated successfully.');
        }
    }

    public function updatePassword()
    {
        $request = $this->request->getPost();
        $request['id'] = user()->id;

        if (!Password::verify($request['current_password'], user()->password_hash)) {
            return redirect()->back()
                ->with('status', 'password-no-match')
                ->with('errors', 'Current password does not match.');
        }
        $validation = \Config\Services::validation();
        $validation->setRules([
            'current_password' => 'required',
            'password' => 'required|min_length[8]|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ]);
        if (!$validation->run($request)) {
            return redirect()->back()
                ->with('errors', $validation->getErrors());
        }

        $hashedPassword = Password::hash($request['password']);

        $this->users->update(user()->id, ['password_hash' => $hashedPassword]);

        return redirect()->back()
            ->with('status', 'password-updated')
            ->with('success', 'Password updated successfully.');
    }

    public function destroy()
    {
        $request = $this->request->getPost();

        if (!Password::verify($request['password'], user()->password_hash)) {
            return redirect()->back()
                ->with('status', 'password-confirm-no-match')
                ->with('errors', 'Password does not match.');
        }
        $userId = user()->id;
        $this->auth->logout();
        $this->users->delete($userId);

        return redirect()->to(site_url('/'));
    }
}
