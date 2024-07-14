<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceManager extends Component
{
    public $date, $check_in, $check_out, $location;
    public $attendances;

    public function mount()
    {
        $this->attendances = Attendance::where('user_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.attendance-manager');
    }

    public function checkIn()
    {
        $this->validate([
            'location' => 'required|string|max:255',
        ]);

        $todayAttendance = Attendance::where('user_id', Auth::id())->whereDate('date', now()->toDateString())->first();

        if ($todayAttendance) {
            session()->flash('message', 'You have already checked in today.');
            return;
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'date' => now()->toDateString(),
            'check_in' => now()->toTimeString(),
            'location' => $this->location,
        ]);

        session()->flash('message', 'Check-in successful.');
        $this->reset(['location']);
        $this->mount();
    }

    public function checkOut()
    {
        $todayAttendance = Attendance::where('user_id', Auth::id())->whereDate('date', now()->toDateString())->first();

        if (!$todayAttendance || $todayAttendance->check_out) {
            session()->flash('message', 'You have not checked in today or you have already checked out.');
            return;
        }

        $todayAttendance->update([
            'check_out' => now()->toTimeString(),
        ]);

        session()->flash('message', 'Check-out successful.');
        $this->mount();
    }
}

