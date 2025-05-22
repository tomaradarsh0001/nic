@extends('layouts.app')

@section('title', 'Mail Settings')

@section('content')
<style>
    .pagination .active a {
        color: #ffffff !important;
    }

    .required-error-message {
        display: none;
    }

    .required-error-message {
        margin-left: -1.5em;
        margin-top: 3px;
    }

    .form-check-inputs[type=checkbox] {
        border-radius: .25em;
    }

    .form-check .form-check-inputs {
        float: left;
        margin-left: -1.5em;
    }

    .form-check-inputs {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0;
    }
    .testMail{
        cursor: pointer;
    }
    .loader {
    display: none;
    border: 8px solid #7e7487;
    border-top: 8px solid #4fc4c1;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
    position: absolute;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Settings</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Mails</li>
            </ol>
            </li>
            </ol>

        </nav>
    </div>
</div>
<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

<hr>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between py-3">
            <h6 class="mb-0 text-uppercase tabular-record_font align-self-end">Mails</h6>
            <a href="{{route('settings.mail.create')}}"><button class="btn btn-primary">+ Add Mail</button></a>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Test Mail</th>
                    <th scope="col">Action</th>
                    <th scope="col">From</th>
                    <th scope="col">Host</th>
                    <th scope="col">Port</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Encryption</th>
                    <th scope="col">status</th>
                    @haspermission('settings.mail.update')
                        <th scope="col">Edit</th>
                    @endhaspermission
                </tr>
            </thead>
            <tbody>
                @forelse($emails as $index => $email)
                <tr class="">
                    <th scope="row">{{$index+1}}</th>
                    <td>
                        <div class="testMail text-primary" data-id="{{$email->id}}">Test Mail</div>
                        <div class="loader" data-loader="{{$email->id}}"></div>
                        <div class="testMailError text-danger text-capitalize"></div>
                        <div class="testMailSuccess text-success text-capitalize"></div>
                    </td>
                    <td>{{$email->action}}</td>
                    <td>{{$email->email}}</td>
                    <td>{{$email->host}}</td>
                    <td>{{$email->port}}</td>
                    <td>{{$email->key}}</td>
                    <td>
                        @php
                        $length = strlen($email->auth_token);
                        $password = $length > 4 ? str_repeat('x', $length - 4) . substr($email->auth_token, -4) :
                        $email->auth_token;

                        @endphp
                        {{$password}}
                    </td>
                    <td>{{$email->encryption}}</td>
                    <td>
                        @if(auth()->user()->can('settings.mail.status'))
                        @if($email->status == 1)
                        <a href="{{route('settings.mail.status',$email->id)}}">
                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i
                                    class="bx bxs-circle me-1"></i>Active</div>
                        </a>
                        @else
                        <a href="{{route('settings.mail.status',$email->id)}}">
                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i
                                    class="bx bxs-circle me-1"></i>In-Active</div>
                        </a>
                        @endif
                        @else
                        @if($email->status == 1)
                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i
                                class="bx bxs-circle me-1"></i>Active</div>
                        @else
                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i
                                class="bx bxs-circle me-1"></i>In-Active</div>
                        @endif
                        @endif
                    </td>
                    @haspermission('settings.mail.update')
                    <td>
                        <div class="d-flex gap-3">
                            <a href="{{route('settings.mail.edit',$email->id)}}"><button type="button"
                                    class="btn btn-primary px-3">Edit</button></a>
                        </div>
                    </td>
                    @endhaspermission
                </tr>
                @empty
                <p class="text-danger text-center text-capitalize fs-5">No Mails available</p>
                @endforelse

            </tbody>
        </table>
        {{ $emails->links() }}
    </div>
</div>


@endsection
@section('footerScript')
<script>
    $('.testMail').on('click', function () {
        var urlTemplate = "{{ route('settings.mail.mailTest', ['id' => 'ID_PLACEHOLDER']) }}";
        var emailId = $(this).data('id');
        var url = urlTemplate.replace('ID_PLACEHOLDER', emailId);
        var span = $(this);
        var loader = $(this).siblings('.loader');
        var error = $(this).siblings('.testMailError');
        var success = $(this).siblings('.testMailSuccess');
        span.hide()
        loader.show();
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            data: {
                _token: '{{csrf_token()}}'
            },
            success: function (response) {
                //console.log(response);
                if (response.success === true) {
                    span.show()
                    loader.hide();
                    success.html(response.message)
                } else if (response.success === false) {
                    span.show()
                    loader.hide();
                    error.html(response.message)
                } else {
                }
            },
            error: function (response) {
                console.log(response);
            }

        })
    })
</script>

@endsection