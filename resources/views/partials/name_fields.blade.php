@php
    $model = $user ?? $member ?? $staffMember ?? $adminAccount ?? $resident ?? $vendor ?? null;
@endphp
<div class="form-group" style="margin-bottom: 15px;">
    <label>First Name</label>
    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $model->first_name ?? '') }}" maxlength="100" style="width: 100%; padding: 8px;">
</div>
<div class="form-group" style="margin-bottom: 15px;">
    <label>Last Name</label>
    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $model->last_name ?? '') }}" maxlength="100" style="width: 100%; padding: 8px;">
</div>
