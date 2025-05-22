@extends('layouts.app')
@section('title', 'Property Merging')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Settings</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item">Miscellaneous</li>
                <li class="breadcrumb-item active" aria-current="page">Property Merging</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('colony.merge') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="colonyToBeMerged" class="form-label">Colony to be Merged</label>
                <div class="row align-items-center">
                    <div class="col-10">
                        <select id="colonyToBeMerged" name="colonyToBeMerged" class="form-control">
                            <option value="">-- Select Colony --</option>
                            @foreach($colonyList as $colony)
                                <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 text-center">
                        <span id="colonyToBeMergedCount" class="text-muted">Count: 0</span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="colonyMergedWith" class="form-label">Merge with Colony</label>
                <div class="row align-items-center">
                    <div class="col-10">
                        <select id="colonyMergedWith" name="colonyMergedWith" class="form-control">
                            <option value="">-- Select Colony --</option>
                            @foreach($colonyList as $colony)
                                <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 text-center">
                        <span id="colonyMergedWithCount" class="text-muted">Count: 0</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Merge Colonies</button>
        </form>
    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const colonyToBeMergedDropdown = document.getElementById('colonyToBeMerged');
    const colonyMergedWithDropdown = document.getElementById('colonyMergedWith');
    const colonyToBeMergedCount = document.getElementById('colonyToBeMergedCount');
    const colonyMergedWithCount = document.getElementById('colonyMergedWithCount');

    // Function to fetch and update property count
    const fetchPropertyCount = async (colonyId, targetElement) => {
        if (!colonyId) {
            targetElement.textContent = 'Count: 0';
            return;
        }

        try {
            const response = await fetch(`{{ route('colony.propertyCount') }}?colonyId=${colonyId}`);
            const data = await response.json();
            targetElement.textContent = `Count: ${data.count || 0}`;
        } catch (error) {
            console.error('Error fetching property count:', error);
            targetElement.textContent = 'Count: 0';
        }
    };

    // Event listeners for dropdown changes
    colonyToBeMergedDropdown.addEventListener('change', function () {
        fetchPropertyCount(this.value, colonyToBeMergedCount);
    });

    colonyMergedWithDropdown.addEventListener('change', function () {
        fetchPropertyCount(this.value, colonyMergedWithCount);
    });
});
</script>
