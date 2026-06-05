@extends('layouts.portal')
@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Overview Dashboard</h2>
    <p class="text-slate-500 mt-1">Welcome back. Here is what's happening in your property today.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    <!-- Total Members -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Members</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalMembers }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-3xl shadow-inner">
                <i class='bx bxs-user'></i>
            </div>
        </div>
        <div class="relative z-10 mt-4 flex items-center text-sm font-medium text-emerald-600">
            <i class='bx bx-trending-up mr-1 text-lg'></i> Active in community
        </div>
    </div>

    <!-- Total Staff -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Staff</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalStaff }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl shadow-inner">
                <i class='bx bxs-user-circle'></i>
            </div>
        </div>
        <div class="relative z-10 mt-4 flex items-center text-sm font-medium text-slate-500">
            Managing operations
        </div>
    </div>

    <!-- Society Fund -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Society Fund</p>
                <h3 class="text-3xl font-extrabold text-slate-800">₹{{ number_format($societyFund, 2) }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl shadow-inner">
                <i class='bx bx-money'></i>
            </div>
        </div>
        <div class="relative z-10 mt-4 flex items-center text-sm font-medium text-emerald-600">
            <i class='bx bx-wallet mr-1 text-lg'></i> Healthy balance
        </div>
    </div>

    <!-- Unpaid Maintenance -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Unpaid Maint.</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $unpaidMaintenance }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-3xl shadow-inner">
                <i class='bx bxs-file'></i>
            </div>
        </div>
        <div class="relative z-10 mt-4 flex items-center text-sm font-medium text-rose-500">
            <i class='bx bx-time-five mr-1 text-lg'></i> Pending collection
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
    <!-- Registry Table -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2"><i class='bx bx-list-check text-indigo-500'></i> Recent Registry</h3>
            <button class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">View All</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest">
                        <th class="p-4 rounded-l-xl font-bold">#</th>
                        <th class="p-4 font-bold">In Time</th>
                        <th class="p-4 rounded-r-xl font-bold">Visitor Name</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 font-medium">
                    @forelse($recentRegistry as $i => $entry)
                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                        <td class="p-4">{{ $i + 1 }}</td>
                        <td class="p-4 text-slate-500">{{ $entry->created_at?->format('M d, H:i') }}</td>
                        <td class="p-4">{{ $entry->visitor_name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-6 text-center text-slate-400 italic">No registry entries found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Members Directory -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2"><i class='bx bx-group text-blue-500'></i> Members Directory</h3>
            <a href="{{ route('admin.members.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">View Directory</a>
        </div>
        <div class="overflow-x-auto flex-grow">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest">
                        <th class="p-4 rounded-l-xl font-bold">#</th>
                        <th class="p-4 font-bold">Email</th>
                        <th class="p-4 rounded-r-xl font-bold">Username</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 font-medium">
                    @forelse($recentMembers as $i => $member)
                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                        <td class="p-4">{{ $i + 1 }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($member->username, 0, 1)) }}</div>
                                {{ $member->email }}
                            </div>
                        </td>
                        <td class="p-4 text-slate-600">{{ $member->username }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-6 text-center text-slate-400 italic">No members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('admin.members.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-slate-900 text-white font-semibold text-sm hover:bg-indigo-600 hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto">
                <i class='bx bx-user-plus mr-2'></i> Manage All Members
            </a>
        </div>
    </div>
</div>
@endsection
