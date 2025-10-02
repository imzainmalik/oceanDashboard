<div class="list-group">
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

    <div class="list-group-item d-flex justify-content-between align-items-center">
        <span>Show {{ ucfirst($feature) }}</span>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="permissions[]" 
                   value="{{ $feature }}_show">
        </div>
    </div>
</div>
