@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Admin List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Admin List</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Admin List</h4>
                            <div class="card-header-action">
                                <a href="{{route('admin.create')}}" class="btn btn-primary">Add Admin</a>
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
                                        <th>Email</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach($adminData as $admin)
                                        <tr>
                                            <td>{{ ($adminData->currentPage() - 1) * $adminData->perPage() + $loop->iteration }}</td>
                                            <td>
                                                <p class="font-weight-bold text-capitalize">
                                                    {{$admin->fullName}}
                                                </p>
                                            </td>
                                            <td>{{$admin->email}}</td>
                                            <td>
                                                {{\Carbon\Carbon::parse($admin->birth_date)->format('d M Y')}}
                                            </td>
                                            <td>
                                                <p class="text-uppercase">{{$admin->gender}}</p>
                                            </td>
                                            <td>
                                                <a href="{{route('admin.edit',$admin->id)}}" class="btn btn-warning">Edit</a>
                                                @if(auth()->id() !== $admin->id)
                                                    <a href="#" class="btn btn-danger"
                                                       onclick="confirmDelete({{$admin->id}},'{{$admin->first_name}}')">Delete</a>
                                                @endif

                                                <form id="delete-form-{{$admin->id}}"
                                                      action="{{route('admin.destroy',$admin->id)}}" method="POST"
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
                                    {{ $adminData->links() }}
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
