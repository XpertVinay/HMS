@extends('layouts.portal')

@section('title', 'Portal Menus')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Portal Menus</h2>
            <button class="btn-custom primary" data-toggle="modal" data-target="#addMenuModal">
                <i class='bx bx-plus'></i> Add Menu Item
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-custom">
                <div class="card-body">
                    @if($menus->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Title</th>
                                        <th>URL</th>
                                        <th>Type</th>
                                        <th>Target</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menus as $menu)
                                        @include('admin.portal_menus.partials.menu_row', ['menu' => $menu, 'level' => 0])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-gray-500">
                            <i class='bx bx-menu text-5xl mb-3'></i>
                            <p>No custom portal menus found. The default standard menus will be shown on the public portal.</p>
                            <button class="btn-custom primary mt-3" data-toggle="modal" data-target="#addMenuModal">
                                Create First Menu Item
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.portal_menus.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title font-bold">Add Menu Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="form-group">
                    <label>Menu Type</label>
                    <select name="type" id="addMenuType" class="form-control" required onchange="toggleAddFields()">
                        <option value="standard">Standard Page</option>
                        <option value="cms">CMS Page</option>
                        <option value="custom">Custom Link</option>
                    </select>
                </div>

                <div class="form-group" id="addStandardGroup">
                    <label>Standard Page</label>
                    <select id="addStandardPage" class="form-control" onchange="updateAddTitleUrl('standard')">
                        <option value="">Select Page...</option>
                        @foreach($standardPages as $page)
                            <option value="{{ $page['url'] }}" data-title="{{ $page['title'] }}">{{ $page['title'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="addCmsGroup" style="display:none;">
                    <label>CMS Page</label>
                    <select id="addCmsPage" class="form-control" onchange="updateAddTitleUrl('cms')">
                        <option value="">Select Page...</option>
                        @foreach($cmsPages as $page)
                            <option value="{{ $page->slug }}" data-title="{{ $page->title }}">{{ $page->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="addTitle" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>URL / Slug <span class="text-danger">*</span></label>
                    <input type="text" name="url" id="addUrl" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Parent Menu (Optional)</label>
                    <select name="parent_id" class="form-control">
                        <option value="">-- None (Top Level) --</option>
                        @foreach($allMenus as $m)
                            <option value="{{ $m->id }}">{{ $m->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Open In</label>
                    <select name="target" class="form-control" required>
                        <option value="_self">Same Window</option>
                        <option value="_blank">New Tab</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-t border-gray-100 p-4">
                <button type="button" class="btn-custom secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-custom primary">Save Menu</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function toggleAddFields() {
        const type = document.getElementById('addMenuType').value;
        const urlInput = document.getElementById('addUrl');
        
        document.getElementById('addStandardGroup').style.display = type === 'standard' ? 'block' : 'none';
        document.getElementById('addCmsGroup').style.display = type === 'cms' ? 'block' : 'none';
        
        if (type === 'custom') {
            urlInput.readOnly = false;
        } else {
            urlInput.readOnly = true;
        }
    }

    function updateAddTitleUrl(type) {
        const selectId = type === 'standard' ? 'addStandardPage' : 'addCmsPage';
        const select = document.getElementById(selectId);
        const option = select.options[select.selectedIndex];
        
        if (option.value) {
            document.getElementById('addTitle').value = option.getAttribute('data-title');
            document.getElementById('addUrl').value = option.value;
        }
    }
</script>
@endpush
