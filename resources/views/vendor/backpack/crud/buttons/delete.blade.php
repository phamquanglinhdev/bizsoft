@if ($crud->hasAccess('delete'))
    <a href="javascript:void(0)" onclick="deleteEntry(this)"><i class="la la-trash"></i>
        {{trans('backpack::crud.delete')}}
    </a>
    <form id="delete-{{$entry->getKey()}}" action="{{url($crud->route."/".$entry->id)}}" method="post">
        @csrf
        @method("delete")
    </form>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax())
    @endpush
@endif
<script>

    if (typeof deleteEntry != 'function') {
        $("[data-button-type=delete]").unbind('click');

        function deleteEntry(button) {
            // ask for confirmation before deleting an item
            // e.preventDefault();
            var route = $(button).attr('data-route');

            swal({
                title: "{!! trans('backpack::base.warning') !!}",
                text: "{!! trans('backpack::crud.delete_confirm') !!}",
                icon: "warning",
                buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('backpack::crud.delete') !!}"],
                dangerMode: true,
            }).then((value) => {
                if (value) {
                    document.getElementById("delete-{{$entry->getKey()}}").submit();
                }
            });

        }
    }

    // make it so that the function above is run after each DataTable draw event
    // crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
</script>
@if (!request()->ajax())
    @endpush
@endif
