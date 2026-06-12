@extends('layouts.portal')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Service Requests</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Available Requests (Broadcasts)</h5>
        </div>
        <div class="card-body">
            @if($availableRequests->isEmpty())
                <p>No available requests at the moment.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Service Category</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>Phase Started</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($availableRequests as $request)
                            <tr>
                                <td>{{ $request->vendor_category ?? 'General' }}</td>
                                <td>{{ $request->subject }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($request->description, 50) }}</td>
                                <td>
                                    {{ $request->vendor_broadcast_started_at ? $request->vendor_broadcast_started_at->diffForHumans() : 'N/A' }}
                                </td>
                                <td>
                                    <form action="{{ route('vendor.services.accept', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Accept</button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#passModal{{ $request->id }}">Pass</button>
                                </td>
                            </tr>

                            <!-- Pass Modal -->
                            <div class="modal fade" id="passModal{{ $request->id }}" tabindex="-1" aria-labelledby="passModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('vendor.services.pass', $request->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="passModalLabel">Pass on Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="comment">Reason for passing:</label>
                                                    <textarea name="comment" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Confirm Pass</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">My Active Requests</h5>
        </div>
        <div class="card-body">
            @if($activeRequests->isEmpty())
                <p>No active requests currently.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeRequests as $request)
                            <tr>
                                <td>{{ $request->subject }}</td>
                                <td><span class="badge bg-warning">{{ ucfirst($request->vendor_service_status) }}</span></td>
                                <td>
                                    @if($request->vendor_service_status === 'negotiating')
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $request->id }}">Generate Invoice</button>
                                    @endif
                                    <form action="{{ route('vendor.services.complete', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Mark Completed</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Invoice Modal -->
                            <div class="modal fade" id="invoiceModal{{ $request->id }}" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('vendor.services.invoice', $request->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="invoiceModalLabel">Generate Invoice</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label for="amount">Agreed Amount</label>
                                                    <input type="number" name="amount" step="0.01" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="task_details">Task Details</label>
                                                    <textarea name="task_details" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Submit Invoice</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Completed Requests</h5>
        </div>
        <div class="card-body">
            @if($completedRequests->isEmpty())
                <p>No completed requests yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Invoice Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedRequests as $request)
                            <tr>
                                <td>{{ $request->subject }}</td>
                                <td>${{ number_format($request->vendor_invoice_amount, 2) }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
