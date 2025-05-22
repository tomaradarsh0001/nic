@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<!--Breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Edit User</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item">User</li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End -->
    <div>
        <style>
            .form-select[multiple] {
                padding-right: .75rem;
                background-image: none;
                min-height: 310px !important;
            }

            .custom-dropdown {
                width: 100%;
            }

            /* .dropdown-menu.show {
                width: 100%;
            } */

            .horizontal-menu {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                max-height: 500px;
                overflow-y: auto;
                padding: 0;
                margin: 0;
                list-style: none;
                gap: 10px;
                width: 100%;
                margin-top: 10px;
            }

            .horizontal-menu li {
                display: flex;
                align-items: center;
            }
        </style>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body">
                    
                    <form action="{{ route('user.permission.update', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="email" value="{{ $user->email }}" class="form-control"
                            placeholder="Email">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="pb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                        placeholder="Name" required>
                                </div>
                                <div class="pb-4">
                                    <label for="Roles" class="form-label">Select Roles</label>
                                    <select class="form-select" name="roles[]" aria-label="Default select example" multiple
                                        required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}"
                                                {{ in_array($role, $userRoles) ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 pb-4">
                                <label for="Roles" class="form-label">Select Permissions</label>
                                <div class="dropdown">
                                    <div class="btn btn-secondary custom-dropdown">
                                        Select permissions
                                    </div>
                                    <ul class="horizontal-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($permissions as $permission)
                                            <li>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" name="permissions[]" class="permission-checkbox"
                                                        value="{{ $permission->name }}"
                                                        @if ($user->hasPermissionTo($permission->name)) checked @endif>
                                                    {{ $permission->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div id="permissionsError" class="text-danger"></div>
                            </div>

                        </div>
                        <div class="row">
                            
                            <div class="col-12 col-lg-4 pb-4">
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
