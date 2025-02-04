<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Password;

class UserController extends BaseController
{
    protected $users;
    protected $groups;

    public function __construct()
    {
        $this->users = new UserModel();
        $this->groups = new \Myth\Auth\Models\GroupModel();
    }

    public function index()
    {
        $data = [
            'title' => 'USER MANAGEMENT',
            'auth_groups' => $this->users->allGroups(),
        ];

        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('users')
                ->select('users.id as userid, username, email, active, group_id, name as role, created_at, full_name, user_image')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
                ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
                ->where('users.deleted_at IS NULL');

            return DataTable::of($builder)->addNumbering('DT_RowIndex')
                ->edit('user_image', function ($row) {
                    return '<img src="' . base_url('assets/img/profile/' . $row->user_image) . '" alt="User Image" width="50" onerror="this.onerror=null;this.src=\'https://placehold.co/100x100\'"/>';
                })
                ->edit('role', function ($row) {
                    return $row->role === 'User' ? '<span class="badge bg-info">User</span>' : ($row->role === 'Admin' ? '<span class="badge bg-warning">Admin</span>' : ($row->role === 'SuperAdmin' ? '<span class="badge bg-success">Super Admin</span>' :
                        '<span class="badge bg-secondary">No Role</span>'));
                })
                ->edit('created_at', function ($row) {
                    return date('d M Y', strtotime($row->created_at));
                })
                ->edit('active', function ($row) {
                    return $row->active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->add('action', function ($row) {
                    return '<a href="#" class="btn btn-sm btn-primary editUser" data-user="' . $row->username . '"><i class="bi bi-pencil-square"></i></a>
                    <button type="submit" class="btn btn-sm btn-danger deleteUser" data-user="' . $row->username . '"><i class="bi bi-trash"></i></button>';
                })
                ->hide('userid')->hide('group_id')
                ->setSearchableColumns(['username', 'email', 'full_name'])
                ->toJson(true);
        }

        return view('Pages/dashboard/users/index', $data);
    }

    public function show($username)
    {
        $db = db_connect();
        $builder = $db->table('users')
            ->select('users.id as userid, username, email, active, group_id, name as role, created_at, full_name, user_about, user_image')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->where('users.deleted_at IS NULL')
            ->where('username', $username);
        $user = $builder->get()->getRowArray();
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON($user);
    }

    public function store()
    {
        try {
            $newToken = csrf_hash();
            $data = $this->request->getPost();
            $data['password_hash'] = ! empty($data['password']) ?  Password::hash($data['password']) : null;

            $addUser = $this->users->withGroup($data['role'])->save($data);
            $insertId = $this->users->getInsertID();
            if ($addUser) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_CREATED)
                    ->setJSON([
                        'status' => true,
                        'message' => 'User added successfully',
                        'id' => $insertId,
                        'token' => $newToken
                    ]);
            } else {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Failed to add user',
                        'errors' => $this->users->errors(),
                        'token' => $newToken
                    ]);
            }
        } catch (\Exception $e) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'token' => $newToken
                ]);
        }
    }

    public function update($username)
    {
        try {
            $newToken = csrf_hash();
            $user = $this->users->where('username', $username)->first()->toArray();
            if (!$user) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                    ->setJSON([
                        'status' => false,
                        'message' => 'User not found',
                        'token' => $newToken
                    ]);
            }
            $userId = $user['id'];
            $this->users->skipValidation(true);
            $validation = \Config\Services::validation();
            $validation->setRules([
                'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
                'full_name' => 'required',
                'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$userId}]",
                'role' => 'required',
                'active' => 'required',
                'password' => 'permit_empty|min_length[8]',
            ]);

            if (!$validation->run($this->request->getPost())) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Failed to update user',
                        'errors' => $validation->getErrors(),
                        'token' => $newToken
                    ]);
            }

            $data = $this->request->getPost();

            $data['password_hash'] = ! empty($data['password']) ? Password::hash($data['password']) : null;
            unset($data['password']);
            if (empty($data['password_hash'])) {
                unset($data['password_hash']);
            }

            $updateUser =  $this->users->update($userId, $data);

            $allGroups = $this->users->allGroups(); // Contoh: [['id' => 1, 'name' => 'Admin'], ['id' => 2, 'name' => 'User']]
            $groupId = null;
            foreach ($allGroups as $group) {
                if ($group['name'] === $data['role']) {
                    $groupId = $group['id'];
                    break;
                }
            }

            $this->groups->removeUserFromAllGroups($userId);
            $this->groups->addUserToGroup($userId, $groupId);
            if ($updateUser) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'status' => true,
                        'message' => 'User updated successfully',
                        'token' => $newToken
                    ]);
            } else {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Failed to update user',
                        'errors' => $this->users->errors(),
                        'token' => $newToken
                    ]);
            }
        } catch (\Exception $e) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'token' => $newToken
                ]);
        }
    }

    public function destroy($username)
    {
        try {
            $newToken = csrf_hash();
            $user = $this->users->where('username', $username)->first();
            if (!$user) {
                // Jika user tidak ditemukan, kirimkan respons error
                return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                    ->setJSON([
                        'status' => false,
                        'message' => 'User not found.',
                        'errors' => $this->users->errors(),
                        'token' => $newToken
                    ]);
            }

            // Menghapus user berdasarkan id
            $delete = $this->users->delete($user->id);
            if ($delete) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'status' => true,
                        'message' => 'User deleted successfully.',
                        'token' => $newToken
                    ]);
            } else {
                return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Failed to delete user.',
                        'errors' => $this->users->errors(),
                        'token' => $newToken
                    ]);
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'token' => $newToken
                ]);
        }
    }
}
