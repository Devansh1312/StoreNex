@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <!-- Content Header (Page header) -->
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <form action="{{ route('UpdateStaff', base64_encode($staff->id)) }}" method="POST" name="editStaffForm" id="editStaffForm">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Staff</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Name:</label>
                                <input type="text" class="form-control" name="edit_name" placeholder="Enter the name" value="{{old('edit_name',$staff->name )}}" />
                                @error('edit_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email:</label>
                                <input type="email" class="form-control" name="edit_email" placeholder="Enter the email" value="{{old('edit_email', $staff->email) }}" />
                                @error('edit_email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">Phone:</label>
                                <input type="text" class="form-control" name="edit_phone" placeholder="Enter the phone number" value="{{old('edit_phone', $staff->phone)}}" />
                                @error('edit_phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">Password:</label>
                                <input type="password" class="form-control" name="edit_password" placeholder="Enter the new password" />
                                @error('edit_password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="updateStaffBtn">UPDATE</button>
                            <a href="{{route('Staff')}}">
                                <button type="button" class="btn btn-secondary">Close</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
