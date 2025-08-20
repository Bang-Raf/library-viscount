<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ManajemenUser extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $showForm = false;
    public $editMode = false;
    public $userId;

    // Form fields
    public $name = '';
    public $username = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'pustakawan';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'role' => 'required|in:administrator,pustakawan'
        ];

        if (!$this->editMode) {
            // Stronger password policy
            $rules['password'] = [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
            ];
        } else {
            $rules['username'] = 'required|string|max:255|unique:users,username,' . $this->userId;
            $rules['email'] = 'nullable|email|unique:users,email,' . $this->userId;
            $rules['password'] = [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
            ];
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi',
        'username.required' => 'Username wajib diisi',
        'username.unique' => 'Username sudah digunakan',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
        'password.confirmed' => 'Konfirmasi password tidak sesuai',
        'role.required' => 'Role wajib dipilih'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function tambahUser()
    {
        // Cek apakah user adalah administrator
        if (auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat menambah user!');
            return;
        }

        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function editUser($id)
    {
        // Cek apakah user adalah administrator
        if (auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat mengedit user!');
            return;
        }

        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role = $user->role;
        
        $this->showForm = true;
        $this->editMode = true;
    }

    public function simpan()
    {
        // Cek apakah user adalah administrator
        if (auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat menyimpan data user!');
            return;
        }

        $this->validate();

        if ($this->editMode) {
            $user = User::findOrFail($this->userId);
            $data = [
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email ?: null,
                'role' => $this->role,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);
            session()->flash('message', 'Data user berhasil diupdate!');
        } else {
            User::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email ?: null,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);
            
            session()->flash('message', 'User baru berhasil ditambahkan!');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function hapus($id)
    {
        // Cek apakah user adalah administrator
        if (auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat menghapus user!');
            return;
        }

        // Tidak bisa menghapus user sendiri
        if ($id == auth()->id()) {
            session()->flash('error', 'Tidak dapat menghapus akun sendiri!');
            return;
        }

        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'User berhasil dihapus!');
    }

    public function resetPassword($id)
    {
        // Cek apakah user adalah administrator
        if (auth()->user()->role !== 'administrator') {
            session()->flash('error', 'Hanya administrator yang dapat reset password!');
            return;
        }

        $user = User::findOrFail($id);
        // Generate a secure random temporary password
        $newPassword = Str::random(12);
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // Invalidate other sessions and remember tokens
        if (method_exists($user, 'setRememberToken')) {
            $user->setRememberToken(Str::random(60));
            $user->save();
        }

        // Delete other active sessions for this user
        if (config('session.driver') === 'database') {
            \DB::table(config('session.table', 'sessions'))
                ->where('user_id', $user->id)
                ->delete();
        }

        // Show the temporary password once to the administrator without storing it in logs
        session()->flash('message', "Password user {$user->name} berhasil direset. Password sementara: {$newPassword}. Minta pengguna untuk mengganti password setelah login.");
    }

    public function batalForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'pustakawan';
        $this->editMode = false;
    }

    public function render()
    {
        // Cek apakah user adalah administrator
        if (auth()->user()->role !== 'administrator') {
            return view('livewire.access-denied');
        }

        $query = User::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.manajemen-user', [
            'users' => $users,
            'totalUser' => User::count(),
            'totalAdmin' => User::where('role', 'administrator')->count(),
            'totalPustakawan' => User::where('role', 'pustakawan')->count(),
        ]);
    }
}
