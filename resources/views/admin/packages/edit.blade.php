@extends('layouts.app')

@section('content')
<script src="{{ asset('js/form-confirmations.js') }}"></script>
<div class="container" style="padding: 30px; max-width: 800px;">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.packages.index') }}" style="color: #4f46e5; text-decoration: none; margin-bottom: 20px; display: inline-block;">
            <i class="fas fa-arrow-left"></i> Back to Packages
        </a>
        <h1 style="font-size: 2rem; color: #1f2937; margin-top: 10px;">Edit Package</h1>
    </div>

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.packages.update', $package) }}" method="POST" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Package Name *</label>
            <input type="text" name="name" value="{{ old('name', $package->name) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;" placeholder="e.g., College Program">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Description</label>
            <textarea name="description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;" placeholder="Package description...">{{ old('description', $package->description) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Price (₹) *</label>
            <input type="number" name="price" value="{{ old('price', $package->price) }}" step="0.01" min="0" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;" placeholder="20000.00">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Maximum Courses Allowed *
                <span style="font-weight: normal; color: #6b7280; font-size: 0.875rem;">(Number of courses users can select from this package)</span>
            </label>
            <input type="number" name="max_courses" value="{{ old('max_courses', $package->max_courses ?? 1) }}" min="1" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;" placeholder="e.g., 3">
            <small style="color: #6b7280; font-size: 0.875rem;">
                <i class="fas fa-info-circle"></i> 
                This limits how many courses users can select when subscribing to this package.
                You can set any number (no maximum limit).
            </small>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Target Type *</label>
                <select name="target_type" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;">
                    <option value="group" {{ old('target_type', $package->target_type) === 'group' ? 'selected' : '' }}>Group</option>
                    <option value="individual" {{ old('target_type', $package->target_type) === 'individual' ? 'selected' : '' }}>Individual</option>
                </select>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Delivery Mode *</label>
                <select name="delivery_mode" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;">
                    <option value="one_to_many" {{ old('delivery_mode', $package->delivery_mode) === 'one_to_many' ? 'selected' : '' }}>One to Many</option>
                    <option value="one_on_one" {{ old('delivery_mode', $package->delivery_mode) === 'one_on_one' ? 'selected' : '' }}>One on One</option>
                </select>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Schedule Type *</label>
                <select name="schedule_type" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;">
                    <option value="fixed" {{ old('schedule_type', $package->schedule_type) === 'fixed' ? 'selected' : '' }}>Fixed</option>
                    <option value="choose" {{ old('schedule_type', $package->schedule_type) === 'choose' ? 'selected' : '' }}>Choose</option>
                    <option value="flexible" {{ old('schedule_type', $package->schedule_type) === 'flexible' ? 'selected' : '' }}>Flexible</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $package->is_popular) ? 'checked' : '' }} style="margin-right: 8px;">
                <span style="font-weight: 500; color: #374151;">Mark as Popular</span>
            </label>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Select Courses (3-4 courses required) *</label>
            <div style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 15px; max-height: 300px; overflow-y: auto;">
                @forelse($courses as $course)
                    <label style="display: flex; align-items: center; padding: 10px; cursor: pointer; border-bottom: 1px solid #e2e8f0;">
                        <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" {{ in_array($course->id, old('course_ids', $package->courses->pluck('id')->toArray())) ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>{{ $course->title }}</strong>
                            <div style="font-size: 0.875rem; color: #64748b;">{{ $course->level }} • {{ $course->category }}</div>
                        </div>
                    </label>
                @empty
                    <p style="color: #64748b; padding: 20px; text-align: center;">No active courses available. Please create courses first.</p>
                @endforelse
            </div>
            <small style="color: #64748b; margin-top: 5px; display: block;">You must select between 3 and 4 courses for this package.</small>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" style="background-color: #4f46e5; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;">
                Update Package
            </button>
            <a href="{{ route('admin.packages.index') }}" style="background-color: #e2e8f0; color: #374151; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
