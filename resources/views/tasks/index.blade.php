@extends('layouts.main')

@section('content')
<div class="mb-8">
    <div class="flex justify-between mb-8">
        <div></div>
        <a href="{{ route('tasks.create') }}" class="inline-block px-6 py-3 text-white rounded-full bg-blue-300 hover:bg-blue-400">Create New Task</a>
    </div>
</div>

<table id="tasks-table" class="min-w-full divide-y border border-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
            <th class="px-6 py-3"></th>
        </tr>
    </thead>
    <tbody class="divide-y" id="tasks-table-body">
        <!-- Table rows will be dynamically generated here -->
    </tbody>
</table>

@endsection

@push('scripts')
<script>
    // Fetch tasks data from API
        fetch('{{ route('api.tasks.index') }}', {
            headers: {
                'Accept': 'application/json'
            }
        }).then(response => response.json())
        .then(data => {
            const baseUrl = "{{ url('/') }}";
            // Generate table rows with fetched data
            const tasksTableBody = document.getElementById('tasks-table-body');
            data.forEach(task => {
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">${task.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${task.description}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${task.status}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="${baseUrl + '/tasks/' + task.slug + '/edit'}" class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="${baseUrl + '/tasks/' + task.slug}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                `;
                // Replace 'taskSlug' with the actual slug value for edit and delete routes
                row.replace('taskSlug', task.slug);
                tasksTableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error fetching tasks:', error));
</script>
@endpush
