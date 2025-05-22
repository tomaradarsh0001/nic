@extends('layouts.app')

@section('title', 'Users List')

@section('content') 
    <div>
            <div class="col pt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex pb-5 justify-content-between">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add User</a>

                            <div class="d-flex gap-3 mt-2">
                                @haspermission('view role')
                                    <a href="{{ route('roles.index') }}" class="btn btn-info">Roles</a>
                                @endhaspermission
                                
                                @haspermission('view permission')
                                    <a href="{{ route('permissions.index') }}" class="btn btn-warning">Permissions</a>
                                @endhaspermission
                            </div>
                            
                        </div>
                        <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Users</h6>
                        <table class="table mb-0">
                                    <thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Name</th>
											<th scope="col">Email</th>
											<th scope="col">Roles</th>
                                            <th scope="col">Status</th>
											<th scope="col">Action</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($users as $key => $user)
										<tr class="">
											<th scope="row">{{$key+1}}</th>
											<td>{{$user->name}}</td>
											<td>{{$user->email}}</td>
                                            <td>
                                            @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $rolename)
                                                <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                            @endforeach
                                        @endif
                                            </td>
                                            <td>
                                                @if(auth()->user()->can('status.user'))
                                                    @if($user->status == 1)
                                                        <a href="{{route('user.status',$user->id)}}"><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Active</div></a>
                                                        @else
                                                        <a href="{{route('user.status',$user->id)}}"><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>In-Active</div></a>
                                                    @endif
                                                @else
                                                    @if($user->status == 1)
                                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Active</div>
                                                    @else
                                                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>In-Active</div>
                                                    @endif
                                                @endif
                                            </td>
											<td>
                                                <div class="d-flex gap-3">
                                                    @haspermission('update user')
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary px-5">Edit</a>
                                                    @endhaspermission
                                                
                                                    @haspermission('delete user')
                                                        <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger px-5">Delete</a>
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