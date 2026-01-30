@extends('layouts.app')

@section('content')
<script src="{{ asset('js/form-confirmations.js') }}"></script>
<div class="container" style="padding: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 2rem; color: #1f2937;">Packages Management</h1>
        <a href="{{ route('admin.packages.create') }}" style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500;">
            <i class="fas fa-plus"></i> Create New Package
        </a>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-weight: 600;">Name</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-weight: 600;">Price</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-weight: 600;">Courses</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-weight: 600;">Type</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-weight: 600;">Status</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-weight: 600;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0;">
                            <strong>{{ $plan->name }}</strong>
                            @if($plan->is_popular)
                                <span style="background-color: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 12px; font-size: 0.75rem; margin-left: 8px;">Popular</span>
                            @endif
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0;">₹ {{ number_format($plan->price, 2) }}</td>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0;">
                            {{ $plan->courses->count() }} course(s)
                            @if($plan->courses->count() > 0)
                                <ul style="margin: 5px 0 0 20px; font-size: 0.875rem; color: #64748b;">
                                    @foreach($plan->courses->take(2) as $course)
                                        <li>{{ $course->title }}</li>
                                    @endforeach
                                    @if($plan->courses->count() > 2)
                                        <li>+{{ $plan->courses->count() - 2 }} more</li>
                                    @endif
                                </ul>
                            @endif
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0;">
                            <span style="text-transform: capitalize;">{{ $plan->target_type }}</span> /
                            <span style="text-transform: capitalize;">{{ str_replace('_', ' ', $plan->delivery_mode) }}</span>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0;">
                            <span style="text-transform: capitalize;">{{ $plan->schedule_type }}</span>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0;">
                            <a href="{{ route('admin.packages.edit', $plan) }}" style="background-color: #4f46e5; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; margin-right: 5px; font-size: 0.875rem;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.packages.destroy', $plan) }}" method="POST" style="display: inline-block;" data-confirm="Are you sure you want to delete this package?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #ef4444; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: #64748b;">
                            No packages found. <a href="{{ route('admin.packages.create') }}">Create your first package</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($plans->hasPages())
            <div style="margin-top: 20px;">
                {{ $plans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
