@extends('admin.layout.template')
@section('title', $title)
@section('admin-content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Edit Room</h1>

        <div class="card shadow col-6">
            <div class="card-body">
                <form class="form-input">
                    @csrf
                    <input type="hidden" name="id" value="{{ $room->id }}">
                    <div class="form-group">
                        <label>Room Category</label>
                        <select class="form-control" name="room_category_id">
                            <option value="">Select room category</option>
                            @foreach ($room_categories as $room_category)
                                <option value="{{ $room_category->id }}" @if ($room_category->id == $room->room_category_id) selected @endif>{{ $room_category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Room Number</label>
                        <input type="text" class="form-control" name="number" value="{{ $room->number }}">
                    </div>
                    <div class="form-group">
                        <label>Room Floor</label>
                        <input type="text" class="form-control" name="floor" value="{{ $room->floor }}">
                    </div>
                    <div class="form-group">
                        <label>Room Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_available" value="0" @if (!$room->is_available) checked @endif>
                            <label class="form-check-label">
                                Available
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_available" value="1" @if ($room->is_available) checked @endif>
                            <label class="form-check-label">Unavailable</label>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('admin.room') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $('.form-input').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure to update this data?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#409AC7',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((res) => {
                    if (res.isConfirmed) {
                        var formData = new FormData(this);
                        $.ajax({
                            url: "{{ route('admin.room.update') }}",
                            method: "POST",
                            data: formData,
                            beforeSend: function(e) {},
                            complete: function(e) {},
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: res.message,
                                    confirmButtonColor: '#409AC7'
                                });
                            },
                            error: function(res) {
                                $.each(res.responseJSON.errors, function(id, error) {
                                    toastr['error'](error);
                                });
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
