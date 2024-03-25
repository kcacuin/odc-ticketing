<?php

namespace App\Livewire;

use App\Livewire\DataTable\WithPerPagePagination;
use App\Livewire\DataTable\WithBulkActions;
use App\Livewire\DataTable\WithCachedRows;
use App\Livewire\DataTable\WithSorting;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\User;
use App\Mail\VerificationEmail;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Rules\AllowedEmailDomain;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

use ZxcvbnPhp\Zxcvbn;

class UserList extends Component
{
    use WithFileUploads, WithPerPagePagination, WithBulkActions, WithCachedRows, WithSorting;

    public $id;

    // * Filters
    public $filters = [
        'search' => '',
    ];

    public $queryString = ['sorts'];
    
    // * Modal
    public $showCreateModal;
    public $showEditModal;
    public $showDeleteModal;
    
    // * Refs
    public $selectedUserId;

    public string $first_name = '';
    public string $last_name = '';
    public $newImage;
    public $image;
    public string $username = '';
    public $role_id;
    public string $email = '';
    public $text;
    public string $password = '';
    public string $password_confirmation = '';
    public int $strengthScore = 1;
    public array $strengthLevels = [
        1 => ['status' => 'Weak', 'color' => 'odc-bg-clr-red'],
        2 => ['status' => 'Fair', 'color' => 'odc-bg-clr-yellow'],
        3 => ['status' => 'Good', 'color' => 'odc-bg-clr-lightblue'],
        4 => ['status' => 'Strong', 'color' => 'odc-bg-clr-green'],
    ];

    public function getRowsQueryProperty()
    {
        $query = User::query();
        $query->filter([
            'search' => $this->filters['search'] ?? '',
        ]);

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        $roles = Role::all();

        return view('livewire.user-list', [
            'users' => $this->rows ?? [],
            'roles' => $roles,
            'defaultRoleId' => $roles->where('name', 'User')->first()->id,
        ]);
        
    }

    // *** User Creation

    public function create(): void
    {
        $this->reset();
        $this->showCreateModal = true;
    }

    public function register(): void
    {
        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'newImage' => ['nullable', 'image', 'max:5120'],
            // 'role_id' => ['required', 'exists:roles,id'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', new AllowedEmailDomain('odecci.com')],
            'password' => ['required', 'string', 'min:7', 'confirmed', Rules\Password::defaults()],
        ]);

        $password = Hash::make($this->password);

        $filename = null;

        if ($this->newImage) {
            $filename = $this->newImage->store('images');
        }

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $password,
            'image' => $filename,
        ]);

        event(new Registered($user));

        Session::flash('create-user-success', 'Registration successful!');

        $this->reset();
        $this->redirect(Route('admin.index'));
    }

    public function generatePassword(): void
    {
        $lowercase = range('a', 'z');
        $uppercase = range('A', 'Z');
        $digits = range(0,9);
        $special = ['!', '@', '#', '$', '%', '^', '*'];
        $chars = array_merge($lowercase, $uppercase, $digits, $special);
        $length = 12;
        do {
            $password = array();

            for ($i = 0; $i <= $length; $i++) {
                $int = rand(0, count($chars) - 1);
                $password[] = $chars[$int];
            }

        } while (empty(array_intersect($special, $password)));

        $this->setPasswords(implode('', $password));
    }

    public function updatedPassword($value)
    {
        $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
    }

    private function setPasswords($value): void
    {
        $this->password = $value;
        $this->password_confirmation = $value;
        $this->updatedPassword($value);
    }


    // *** Edit and Update User

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUserId = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->role_id = $user->role_id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->image = $user->image;

        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role_id' => ['required'],
            'username' => ['required', 'string', 'min:3', 'max:255', Rule::unique('users')->ignore($this->selectedUserId)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($this->selectedUserId)],
            'newImage' => ['nullable', 'image', 'max:5120'],
        ]);
    
        $user = User::findOrFail($this->selectedUserId);

        $filename = null;

        if ($this->newImage) {
            $filename = $this->newImage->store('images');
        }
    
        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'role_id' => $this->role_id,
            'username' => $this->username,
            'email' => $this->email,
            'image' => $filename,
        ]);

        Session::flash('update-user-success', 'User updated successfully.');
    
        $this->reset();
        $this->redirect(Route('admin.index'));
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUserId = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->image = $user->image;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        $user = User::findOrFail($this->selectedUserId);

        $user->delete();

        Session::flash('delete-user-success', 'User deleted successfully.');

        $this->reset();
        $this->redirect(Route('admin.index'));
    }
}
