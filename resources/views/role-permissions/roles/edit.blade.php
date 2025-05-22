@extends('layouts.app')

@section('title', 'Edit Role')

@section('content') 
    
    <div>
            <div class="col pt-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Edit role details</h6>
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                                <div class="row align-items-end">
                                        <div class="col-12 col-lg-4">
                                            <label for="role_name" class="form-label">Role Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" placeholder="Role Name" required>
                                        </div>
                                        <div class="col-12 col-lg-2">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                            </form>

                        
                                    
                    </div>
                </div>
            </div>
        
            
    </div>

@endsection