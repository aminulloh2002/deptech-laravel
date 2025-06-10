@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Admin List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Employee Paid Leave List</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Employee Paid List</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Total Paid Leave This Year</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach($employeeLeaves as $leave)
                                        <tr>
                                            <td>{{ ($employeeLeaves->currentPage() - 1) * $employeeLeaves->perPage() + $loop->iteration }}</td>
                                            <td>
                                                <p class="font-weight-bold text-capitalize">
                                                    {{$leave->fullName}}
                                                </p>
                                            </td>

                                            <td>
                                                <p class="text-uppercase">{{$leave->total_leaves}}</p>
                                            </td>
                                            <td>
                                                <a href="{{route('employee-paid-leave.show', $leave->id)}}"
                                                   class="btn btn-primary">Paid Leave List</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <div>
                                    {{ $employeeLeaves->links() }}
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
