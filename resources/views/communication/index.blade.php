@extends('layouts.app')

@section('title', 'Templates')

@section('content')

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Settings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Application Configuration</li>
                    <li class="breadcrumb-item active" aria-current="page">Message Templates</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between py-3">
                <h6 class="mb-0 text-uppercase tabular-record_font align-self-end">Templates</h6>
                <a href="{{ route('templates.create') }}"><button class="btn btn-primary">+ Add Template</button></a>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Action</th>
                        <th scope="col">Type</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Templates</th>
                        <th scope="col">Variables</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templates as $template)
                        <tr>
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->action }}</td>
                            <td>{{ $template->type }}</td>
                            <td>{{ $template->subject }}</td>
                            <td>{{ Str::limit($template->template, 50) }}</td>
                            <td>
                                @php
                                    preg_match_all('/\{([^}]*)\}/', $template->template, $matches);
                                    $placeholders = $matches[1];
                                @endphp
                                @foreach ($placeholders as $placeholder)
                                    <span
                                        class="badge rounded-pill text-dark bg-light-success p-1 text-uppercase px-2 mx-1">{{ $placeholder }}</span>
                                @endforeach
                            </td>
                            {{-- <td>{{ $template->status == 1 ? 'Active' : 'Inactive' }}</td> --}}
                            <td>
                                @if ($template->status == 1)
                                    <a href="{{ route('template.status', $template->id) }}">
                                        <div
                                            class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                            <i class="bx bxs-circle me-1"></i>Active
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('template.status', $template->id) }}">
                                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                            <i class="bx bxs-circle me-1"></i>In-Active
                                        </div>
                                    </a>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('template.use', $template->id) }}" class="btn btn-primary px-5">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $templates->links() }}
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

@section('footerScript')
@endsection
