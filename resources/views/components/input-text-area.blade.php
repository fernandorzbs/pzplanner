<div class="mb-3">
    @php
        $for    = $attributes['id'];
        $id     = $for;
    @endphp
    <label for="{{$for}}" class="form-label">{{$attributes['title']}}:</label>
    <textarea {{$attributes->merge(['placeholder' => ''])}} class="form-control" id="{{$id}}" name="{{$id}}">{{ old($id, $attributes['value']) }}</textarea>
</div>
@error($id)
    <style>
        #{{$id}}{
            border : 1px solid red;
        }
    </style>
    <p class="alert alert-danger py-2 mt-n2">{{$message}}</p>
@enderror