<div>
    <div class="mb-4">
        <label for="reportType">Report Type:</label>
        <select id="reportType" wire:model="reportType" class="form-select">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" wire:model="startDate" class="form-control">
    </div>

    <div class="mb-4">
        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" wire:model="endDate" class="form-control">
    </div>

    <div class="mb-4">
        <button wire:click="loadAttendances" class="btn btn-primary">Load Report</button>
    </div>

    <div class="mb-4">
        <button wire:click="export('csv')" class="btn btn-secondary">Export CSV</button>
        <button wire:click="export('xlsx')" class="btn btn-secondary">Export Excel</button>
        <button wire:click="export('pdf')" class="btn btn-secondary">Export PDF</button>
    </div>

    <div class="card">
        <div class="card-header">
            Attendance Report
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Location</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->id }}</td>
                            <td>{{ $attendance->user_id }}</td>
                            <td>{{ $attendance->date }}</td>
                            <td>{{ $attendance->check_in }}</td>
                            <td>{{ $attendance->check_out }}</td>
                            <td>{{ $attendance->location }}</td>
                            <td>{{ $attendance->created_at }}</td>
                            <td>{{ $attendance->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
