@forelse($dataWithPagination as $index => $userActionLog)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $userActionLog->user->name }}</td>
        <td>{{ $userActionLog->module->name }}</td>
        <td>{{ $userActionLog->action }}</td>
        <td>{!! $userActionLog->description !!}</td>
        <td>{{ $userActionLog->created_at }}</td>
        {{-- <td>
            <div class="d-flex gap-3">
                <a href="{{ $userActionLog->url }}"> <button type=" button"
                        class="btn btn-danger px-5">View</button></a>
            </div>
        </td> --}}
    </tr>
@empty
    <p>No user action logs available</p>
@endforelse
<tr>
    <td colspan="14">
        {!! $dataWithPagination->links('pagination.custom') !!}
    </td>
</tr>
