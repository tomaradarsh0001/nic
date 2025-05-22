<div class="col-md-3">
    <div class="form-group">
        <label class="form-label" for="{{ $prefix }}logistic_items_id{{ $prefix !== '' ? ']' : '' }}">Item name:
            <span class="text-danger">*</span></label>
        <select id="{{ $prefix }}logistic_items_id{{ $prefix !== '' ? ']' : '' }}"
            name="{{ $prefix }}logistic_items_id{{ $prefix !== '' ? ']' : '' }}" class="form-select"
            aria-label="Default select example" data-name="logistic_items_id"
            {{ isset($readOnly) && $readOnly ? 'disabled' : '' }}>
            <option value="">Select</option>
            @foreach ($purchaseItem as $data)
                @if ($data->status != 'inactive')
                    <option value="{{ $data->id }}"
                        {{ isset($item) && $item->logistic_items_id == $data->id ? 'selected' : '' }}>
                        {{ $data->name }}
                    </option>
                @endif
            @endforeach
        </select>
        @error($prefix . 'logistic_items_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label class="form-label" for="{{ $prefix }}category_id{{ $prefix !== '' ? ']' : '' }}">Category name:
            <span class="text-danger">*</span></label>
        <select id="{{ $prefix }}category_id{{ $prefix !== '' ? ']' : '' }}"
            name="{{ $prefix }}category_id{{ $prefix !== '' ? ']' : '' }}" class="form-select readonly-select"
            aria-label="Default select example" data-name="category_id"
            {{ isset($readOnly) && $readOnly ? 'disabled' : '' }}>
            <option value="">Select</option>
            @foreach ($purchaseCategory as $data)
                @if ($data->status != 'inactive')
                    <option value="{{ $data->id }}"
                        {{ isset($item) && $item->category_id == $data->id ? 'selected' : '' }}>
                        {{ $data->name }}
                    </option>
                @endif
            @endforeach
        </select>
        @error($prefix . 'category_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label class="form-label" for="{{ $prefix }}purchased_unit{{ $prefix !== '' ? ']' : '' }}">Purchased
            Unit:</span></label>
        <input type="number" id="{{ $prefix }}purchased_unit{{ $prefix !== '' ? ']' : '' }}"
            name="{{ $prefix }}purchased_unit{{ $prefix !== '' ? ']' : '' }}" class="form-control"
            data-name="purchased_unit" value="{{ isset($item) ? $item->purchased_unit : '' }}"
            {{ isset($readOnly) && $readOnly ? 'disabled' : '' }}>
        @error($prefix . 'purchased_unit')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label class="form-label" for="{{ $prefix }}reduced_unit{{ $prefix !== '' ? ']' : '' }}">Reduced
            Unit:</label>
        <input type="number" id="{{ $prefix }}reduced_unit{{ $prefix !== '' ? ']' : '' }}"
            name="{{ $prefix }}reduced_unit{{ $prefix !== '' ? ']' : '' }}" class="form-control"
            data-name="reduced_unit" value="{{ isset($item) ? $item->reduced_unit : '' }}"
            {{ isset($readOnly) && $readOnly ? 'disabled' : '' }}>
        @error($prefix . 'reduced_unit')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label class="form-label" for="{{ $prefix }}per_unit_cost{{ $prefix !== '' ? ']' : '' }}">Per Unit
            Cost:</label>
        <input type="number" id="{{ $prefix }}per_unit_cost{{ $prefix !== '' ? ']' : '' }}"
            name="{{ $prefix }}per_unit_cost{{ $prefix !== '' ? ']' : '' }}" class="form-control"
            data-name="per_unit_cost" value="{{ isset($item) ? $item->per_unit_cost : '' }}"
            {{ isset($readOnly) && $readOnly ? 'disabled' : '' }}>
        @error($prefix . 'per_unit_cost')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

@if (isset($item))
    <input type="hidden" name="{{ $prefix }}id{{ $prefix !== '' ? ']' : '' }}" value="{{ $item->id }}">
@endif
