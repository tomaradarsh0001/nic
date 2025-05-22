@extends('layouts.app')

@section('title', 'Assign Permissions to Role')

@section('content') 
    
    <div>
            <div class="col pt-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Role: {{$role->name}}</h6>
                        <form action="{{ route('roles.givePermission', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                                <div class="">
                                        <div class="row gap-2 text-capitalize">
                                            @foreach($permissions as $permission)
                                                <div class="col-2 d-flex align-items-center gap-1">
                                                    <input type="checkbox" name="permission[]" 
                                                    value="{{$permission->name}}" 
                                                    {{in_array($permission->id,$rolePermission) ? 'checked':''}} 
                                                    />
                                                    <span class="">{{$permission->name}}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-12 col-lg-2 mt-3">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                            </form>          
                    </div>
                </div>
            </div>
    </div>

@endsection