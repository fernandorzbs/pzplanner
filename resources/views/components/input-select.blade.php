<div class="mb-3">
    @php
        $for    = $attributes['id'];
        $id     = $for;
    @endphp
    <label for="{{$for}}" class="form-label">{{$attributes['title']}}:</label>
    <select class="select2 form-select" id="{{$id}}" name="{{$id}}" data-width="100%">
        @foreach($list as $key)
            <option {{ $key->id == $attributes['selectado'] ? 'selected' : '' }} value="{{$key->id}}">{{ $key->{$attributes['displayKey']} }}</option>
        @endforeach
    </select>
    @push('after-script')
    <script src="{{asset('admins/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#{{$id}}").select2();
        });
    </script>
    @endpush
</div>
@error($id)
    <style>
        #{{$id}}{
            border : 1px solid red;
        }
    </style>
    <p class="alert alert-danger py-2 mt-n2">{{$message}}</p>
@enderror