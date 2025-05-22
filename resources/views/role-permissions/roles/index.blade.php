@extends('layouts.app')

@section('title', 'Roles List')

@section('content') 
    
    <div>
            <div class="col pt-3">
                <div class="card">
                    <div class="card-body">
                    <div class="d-flex justify-content-end">
                        @haspermission('create role')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Add Role</a>
                        @endhaspermission
                    </div>
                        <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Roles</h6>
                        <table class="table mb-0">
                                    <thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Name</th>
											<th scope="col">Action</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($roles as $key => $role)
										<tr class="">
											<th scope="row">{{$key+1}}</th>
											<td>{{$role->name}}</td>
											<td>
                                                <div class="d-flex gap-3">
                                                    @haspermission('update role')
                                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary px-5">Edit</a>
                                                    @endhaspermission
                                                
                                                    @haspermission('delete role')
                                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger px-5">Delete</button>
                                                        </form>
                                                    @endhaspermission
                                                
                                                    @haspermission('create role')
                                                    <a href="{{ route('roles.givePermission', $role->id) }}" class="btn btn-warning px-5">Add / Edit Role Permission</a>
                                                    @endhaspermission
                                                </div>
                                                
                                            </td>
										</tr>
										@endforeach
									</tbody>
								</table>
                    </div>
                </div>
            </div>
        
           
</div>
@endsection