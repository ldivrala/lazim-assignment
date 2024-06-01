@extends('layouts.main')

@section('content')
<form id="taskForm" class="max-w-lg mx-auto mt-8 p-6">
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium">Task Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $task->name ?? '') }}" required class="mt-1 p-2 block w-full rounded-md border">
        <span class='text-red-500 text-sm' id="nameError"></span>
    </div>
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium">Description:</label>
        <textarea id="description" name="description" rows="4" required class="mt-1 p-2 block w-full rounded-md border">{{ old('description', $task->description ?? '') }}</textarea>
        <span class='text-red-500 text-sm' id="descriptionError"></span>
    </div>
    <div class="mb-4">
        <label for="status" class="block text-sm font-medium">Status:</label>
        <select id="status" name="status" required class="mt-1 p-2 block w-full rounded-md border">
            <option value="pending" {{ (old('status', $task->status ?? '') == 'pending') ? 'selected' : '' }}>Pending</option>
            <option value="in-progress" {{ (old('status', $task->status ?? '') == 'in-progress') ? 'selected' : '' }}>In Progress</option>
            <option value="dropped" {{ (old('status', $task->status ?? '') == 'dropped') ? 'selected' : '' }}>Dropped</option>
            <option value="done" {{ (old('status', $task->status ?? '') == 'done') ? 'selected' : '' }}>Done</option>
        </select>
        <span class='text-red-500 text-sm' id="statusError"></span>
    </div>
    <button type="button" id="submitBtn" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">{{ isset($task) ? 'Update' : 'Create' }}</button>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('taskForm');
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.addEventListener('click', async function() {
            const formData = new FormData(form);

            try {
                const response = await fetch('{{ isset($task) ? route('api.tasks.update', $task->slug) : route('api.tasks.store') }}', {
                    method: '{{ isset($task) ? 'PUT' : 'POST' }}',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw response;
                }

                const data = await response.json();
                // Redirect to the task index page
                window.location.href = '{{ route('tasks.index') }}';
            } catch (error) {
                console.log(error.status);
                if (error && error.status === 422) {
                    // Handle validation errors
                    try {
                        const errors = (await error.json()).errors;
                        document.getElementById('nameError').textContent = errors.name ? errors.name[0] : '';
                        document.getElementById('descriptionError').textContent = errors.description ? errors.description[0] : '';
                        document.getElementById('statusError').textContent = errors.status ? errors.status[0] : '';
                    } catch (jsonError) {
                        console.error(jsonError.message);
                    }
                } else {
                    console.error(error.message);
                }
            }
        });
    });
</script>

@endpush

@endsection
