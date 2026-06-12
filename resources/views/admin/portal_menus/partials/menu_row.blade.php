<tr>
    <td>
        <form action="{{ route('admin.portal_menus.reorder') }}" method="POST" class="d-inline" id="form-order-{{ $menu->id }}">
            @csrf
            <input type="hidden" name="order[0][id]" value="{{ $menu->id }}">
            <input type="hidden" name="order[0][parent_id]" value="{{ $menu->parent_id }}">
            <input type="number" name="order[0][order]" value="{{ $menu->order }}" class="form-control form-control-sm w-20 inline-block text-center" onchange="document.getElementById('form-order-{{ $menu->id }}').submit()">
        </form>
    </td>
    <td style="padding-left: {{ $level * 30 + 12 }}px">
        @if($level > 0)
            <i class='bx bx-subdirectory-right text-gray-400'></i>
        @endif
        <span class="font-medium text-gray-800">{{ $menu->title }}</span>
    </td>
    <td>
        <span class="text-sm text-gray-500">{{ $menu->url }}</span>
    </td>
    <td>
        <span class="badge badge-{{ $menu->type === 'cms' ? 'success' : ($menu->type === 'standard' ? 'primary' : 'secondary') }}">
            {{ ucfirst($menu->type) }}
        </span>
    </td>
    <td>
        <span class="text-xs text-gray-500">{{ $menu->target }}</span>
    </td>
    <td>
        <button class="btn btn-sm btn-light text-primary" data-toggle="modal" data-target="#editMenuModal{{ $menu->id }}">
            <i class='bx bx-edit'></i>
        </button>
        <form action="{{ route('admin.portal_menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-light text-danger">
                <i class='bx bx-trash'></i>
            </button>
        </form>
    </td>
</tr>

<!-- Edit Modal for {{ $menu->id }} -->
<div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.portal_menus.update', $menu->id) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title font-bold">Edit Menu Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="form-group">
                    <label>Menu Type</label>
                    <select name="type" class="form-control" required>
                        <option value="standard" {{ $menu->type === 'standard' ? 'selected' : '' }}>Standard Page</option>
                        <option value="cms" {{ $menu->type === 'cms' ? 'selected' : '' }}>CMS Page</option>
                        <option value="custom" {{ $menu->type === 'custom' ? 'selected' : '' }}>Custom Link</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ $menu->title }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>URL / Slug <span class="text-danger">*</span></label>
                    <input type="text" name="url" value="{{ $menu->url }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Parent Menu</label>
                    <select name="parent_id" class="form-control">
                        <option value="">-- None (Top Level) --</option>
                        @foreach($allMenus as $m)
                            @if($m->id !== $menu->id)
                                <option value="{{ $m->id }}" {{ $menu->parent_id == $m->id ? 'selected' : '' }}>{{ $m->title }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Visibility <span class="text-danger">*</span></label>
                    <select name="visibility" class="form-control" required>
                        <option value="public" {{ $menu->visibility === 'public' ? 'selected' : '' }}>Public Site</option>
                        <option value="dashboard" {{ $menu->visibility === 'dashboard' ? 'selected' : '' }}>Dashboard Sidebar</option>
                        <option value="both" {{ $menu->visibility === 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Icon Class (Dashboard)</label>
                    <input type="text" name="icon" value="{{ $menu->icon }}" class="form-control" placeholder="e.g. bx-bell">
                </div>

                <div class="form-group">
                    <label>Route Name (Dashboard)</label>
                    <input type="text" name="route_name" value="{{ $menu->route_name }}" class="form-control" placeholder="e.g. events.index">
                    <small class="text-muted">Dynamic prefix like 'admin.' or 'member.' will be applied automatically.</small>
                </div>

                <div class="form-group">
                    <label>Allowed Roles (Dashboard)</label>
                    <div class="d-flex flex-wrap gap-3">
                        @php $roles = is_array($menu->roles) ? $menu->roles : []; @endphp
                        <div class="form-check mr-3">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="admin" id="roleAdmin{{ $menu->id }}" {{ in_array('admin', $roles) ? 'checked' : '' }}>
                            <label class="form-check-label" for="roleAdmin{{ $menu->id }}">Admin</label>
                        </div>
                        <div class="form-check mr-3">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="member" id="roleMember{{ $menu->id }}" {{ in_array('member', $roles) ? 'checked' : '' }}>
                            <label class="form-check-label" for="roleMember{{ $menu->id }}">Member</label>
                        </div>
                        <div class="form-check mr-3">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="staff" id="roleStaff{{ $menu->id }}" {{ in_array('staff', $roles) ? 'checked' : '' }}>
                            <label class="form-check-label" for="roleStaff{{ $menu->id }}">Staff</label>
                        </div>
                        <div class="form-check mr-3">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="vendor" id="roleVendor{{ $menu->id }}" {{ in_array('vendor', $roles) ? 'checked' : '' }}>
                            <label class="form-check-label" for="roleVendor{{ $menu->id }}">Vendor</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Open In</label>
                    <select name="target" class="form-control" required>
                        <option value="_self" {{ $menu->target === '_self' ? 'selected' : '' }}>Same Window</option>
                        <option value="_blank" {{ $menu->target === '_blank' ? 'selected' : '' }}>New Tab</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-t border-gray-100 p-4">
                <button type="button" class="btn-custom secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-custom primary">Update Menu</button>
            </div>
        </form>
    </div>
</div>

@if($menu->children && $menu->children->count() > 0)
    @foreach($menu->children as $child)
        @include('admin.portal_menus.partials.menu_row', ['menu' => $child, 'level' => $level + 1])
    @endforeach
@endif
