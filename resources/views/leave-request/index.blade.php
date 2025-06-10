@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Monthly Paid Leave List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Paid Leave List</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Monthly Paid Leave List</h4>
                            <div class="card-header-action">
                                <a href="{{route('leave-request.create')}}" class="btn btn-primary">Add Monthly Leave</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if(session('success'))
                                <div class="alert alert-success mx-3">
                                    {{session('success')}}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach($leaves as $leave)
                                        <tr>
                                            <td>{{ ($leaves->currentPage() - 1) * $leaves->perPage() + $loop->iteration }}</td>
                                            <td>
                                                <p class="font-weight-bold text-capitalize">
                                                    {{$leave->employee->fullName}}
                                                </p>
                                            </td>
                                            <td>{{$leave->start_date}}</td>
                                            <td>{{$leave->end_date}}</td>
                                            <td>{{$leave->reason}}</td>
                                            <td>
                                                <a href="{{route('leave-request.edit',$leave->id)}}"
                                                   class="btn btn-warning">Edit</a>

                                                <a href="#" class="btn btn-danger"
                                                   onclick="confirmDelete({{$leave->id}},'{{$leave->first_name}}')">Delete</a>

                                                <form id="delete-form-{{$leave->id}}"
                                                      action="{{route('leave-request.destroy',$leave->id)}}" method="POST"
                                                      class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <div>
                                    {{ $leaves->links() }}
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: `Hapus ${name}?`,
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
