@php
    $model = $user ?? $member ?? $staffMember ?? $adminAccount ?? $resident ?? $vendor ?? null;
@endphp
<div class="form-group">
    <label>First Name</label>
    <input type="text" name="first_name" value="{{ old('first_name', $model->first_name ?? '') }}" maxlength="100">
</div>
<div class="form-group">
    <label>Last Name</label>
    <input type="text" name="last_name" value="{{ old('last_name', $model->last_name ?? '') }}" maxlength="100">
</div>
