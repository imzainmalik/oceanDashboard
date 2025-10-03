<div class="list-group">
    @if(ucfirst($feature) != "Documents" || ucfirst($feature) != "Medical_docs" || ucfirst($feature) != "Insurance_docs" || ucfirst($feature) != "Emergency_docs")
    <div class="list-group-item d-flex justify-content-between align-items-center">
        <span>Insert {{ ucfirst($feature) }}</span>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="permissions[]" 
                   value="{{ $feature }}_insert">
        </div>
    </div>

    <div class="list-group-item d-flex justify-content-between align-items-center">
        <span>Update {{ ucfirst($feature) }}</span>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="permissions[]" 
                   value="{{ $feature }}_update">
        </div>
    </div>

    <div class="list-group-item d-flex justify-content-between align-items-center">
        <span>Delete {{ ucfirst($feature) }}</span>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="permissions[]" 
                   value="{{ $feature }}_delete">
        </div>
    </div>
    @endif
    <div class="list-group-item d-flex justify-content-between align-items-center">
        <span>@if(ucfirst($feature) == "Meetings") Join @else Show @endif {{ ucfirst($feature) }}</span>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="permissions[]" 
                   value="@if(ucfirst($feature) == "Meetings") {{ $feature }}_join @else {{ $feature }}_join @endif">
            
        </div>
    </div>
</div>
