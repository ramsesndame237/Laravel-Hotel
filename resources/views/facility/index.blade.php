@extends('template.master')
@section('title', __('Facility'))
@section('content')

@endsection
{{--
@section('footer')
<script>
    $('.delete').click(function() {
        var room_id = $(this).attr('room-id');
        var room_name = $(this).attr('room-name');
        var room_url = $(this).attr('room-url');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: @json(__('Are you sure?')),
            text: @json(__('Room number') . ' ') + room_name + @json(' ' . __('will be deleted, You won\'t be able to revert this!')),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: @json(__('Yes, delete it!')),
            cancelButtonText: @json(__('No, cancel!')),
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                id = "#delete-room-form-" + room_id
                console.log(id)
                $(id).submit();
            }
        })
    });

</script>
@endsection --}}
