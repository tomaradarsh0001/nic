@extends('layouts.app')

@section('title', 'Permissions List')

@section('content') 
    <div>
            <div class="col pt-3">
                <div class="card">
                    <div class="card-body">
                    <div class="d-flex justify-content-end">
                    @haspermission('create permission')
                        <a href="{{ route('permissions.create')  }}"><button class="btn btn-primary">+ Add Permission</button></a>
                    @endhaspermission
                    </div>
                        <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Permissons</h6>
                        <table class="table mb-0">
                                    <thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Name</th>
											<th scope="col">Action</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($permissions as $key => $permission)
										<tr class="">
											<th scope="row">{{$key+1}}</th>
											<td>{{$permission->name}}</td>
											<td>
                                                <div class="d-flex gap-3">
                                                    @haspermission('update permission')
                                                        <a href="{{ route('permissions.edit', $permission->id) }}">
                                                            <button type="button" class="btn btn-primary px-5">Edit</button>
                                                        </a>
                                                    @endhaspermission
                                                
                                                    @haspermission('delete permission')
                                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger px-5">Delete</button>
                                                        </form>
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