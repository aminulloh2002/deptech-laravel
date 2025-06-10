@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Monthly Paid Leave</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{route('leave-request.index')}}">Monthly Leave</a></div>
                <div class="breadcrumb-item active">Create</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12">
                    <div class="card">
                        <form method="post" action="{{route('leave-request.store')}}" class="needs-validation">
                            @csrf
                            <div class="card-header">
                                <h4>Create Monthly Paid Leave</h4>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{session('success')}}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Select Employee</label>
                                        <select class="form-control text-capitalize @error('employee_id') is-invalid @enderror"
                                            name="employee_id" required>
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->fullName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Reason</label>
                                        <input type="text" name="reason"
                                               class="form-control @error('reason') is-invalid @enderror"
                                               value="{{ old('reason') }}" required="">
                                        @error('reasoon')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date"
                                               class="form-control @error('start_date') is-invalid @enderror"
                                               value="{{ old('start_date')}}" required="">
                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>End Date</label>
                                        <input type="date" name="end_date"
                                               class="form-control @error('end_date') is-invalid @enderror"
                                               value="{{ old('end_date')}}" required="">
                                        @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
