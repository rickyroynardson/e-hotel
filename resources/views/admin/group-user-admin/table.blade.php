<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($groups->count())
                @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>
                            <a href="{{ route('admin.group-user-admin.edit', ['id' => $group->id]) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $group->id }}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2">No data found.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $groups->links() }}
</div>
