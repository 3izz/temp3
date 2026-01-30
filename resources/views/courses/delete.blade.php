@extends('layouts.app')

@section('content')
<h1>Admin Dashboard - All Courses</h1>

@if(session('success'))
    <div style="color:green;">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Title</th>
            <th>Instructor</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
        <tr>
            <td>{{ $course->title }}</td>
            <td>{{ $course->instructor->name ?? 'Unknown' }}</td>
            <td>{{ $course->status }}</td>
            <td>
                <a href="{{ route('courses.edit', $course->id) }}">Edit</a>

                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline-block;" data-confirm="Are you sure you want to delete this course?">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $courses->links() }}
@endsection
