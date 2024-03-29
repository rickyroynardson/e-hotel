@extends('admin.layout.template')
@section('title', $title)
@section('admin-content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Banner</h1>

        <div class="card shadow">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-7">
                        <form class="form-search">
                            @csrf
                            <div class="input-group">
                                <select class="form-control" name="search_by">
                                    <option value="name">Name</option>
                                </select>
                                <input type="text" class="form-control" placeholder="Search..." name="search">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="loadTable()"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5" align="right">
                        <a href="{{ route('admin.banner.add') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                        <button class="btn btn-primary" onclick="loadTable()"><i class="fas fa-redo"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="table-data"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            loadTable()

            function loadTable(page) {
                var url = "{{ route('admin.banner') }}";
                if (page != "") {
                    url += "?page=" + page;
                }
                $.ajax({
                    url: url,
                    method: "POST",
                    data: $('.form-search').serialize(),
                    beforeSend: function(e) {},
                    complete: function(e) {},
                    success: function(res) {
                        $('#table-data').html(res);
                        $(".pagination").on('click', '.page-link', function(e) {
                            e.preventDefault();
                            var url = $(this).attr("href");
                            var page = url.split("=")[1];
                            loadTable(page);
                            return false;
                        });
                    },
                    error: function(res) {}
                });
            }

            $('#table-data').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure to delete this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#409AC7',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((res) => {
                    if (res.isConfirmed) {
                        var id = $(this).data('id');
                        var url = "{{ route('admin.banner.delete', ':id') }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            url: url,
                            method: "DELETE",
                            data: {
                                _token: $("meta[name='csrf-token']").attr("content")
                            },
                            beforeSend: function(e) {},
                            complete: function(e) {},
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: res.message,
                                    confirmButtonColor: '#409AC7'
                                }).then(function() {
                                    loadTable();
                                });
                            },
                            error: function(res) {
                                toastr['error']('Delete data failed, there is a problem with the server!');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
