<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Position;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class Karyawan extends Component
{
    use WithPagination;

    public $name, $email, $employeeId, $positionId, $password, $active;
    public $isOpen = false;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->employeeId)],
            'positionId' => 'required|exists:positions,id',
            'password' => $this->employeeId ? 'nullable|min:6' : 'required|min:6',
            'active' => 'required|boolean',
        ];
    }

    public function render()
    {
        return view('livewire.karyawan', [
            'employees' => User::paginate(10),
            'positions' => Position::all(),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'position_id' => $this->positionId,
            'active' => $this->active,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id' => $this->employeeId], $data);

        session()->flash('message', $this->employeeId ? 'User updated successfully.' : 'User created successfully.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $this->employeeId = $id;
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->positionId = $employee->position_id;
        $this->active = $employee->active;
        $this->password = ''; // Reset password field
        $this->isOpen = true;
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->positionId = '';
        $this->active = true; // Default to active
        $this->password = '';
        $this->employeeId = '';
    }
}
