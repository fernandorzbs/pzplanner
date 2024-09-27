<div class="mb-3">
    @php
        $for    = $attributes['id'];
        $id     = $for;
        $type   = $attributes['type'] ?? 'text';
    @endphp
    <label for="{{$for}}" class="form-label">{{$attributes['title']}}:</label>
    @if($type == 'password')
        <div class="d-flex">
            <input type="password" class="form-control" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px" id="{{$id}}" name="{{$id}}" placeholder="{{ $attributes['placeholder'] }}" />
            <button type="button" class="btn btn-dark btn-sm" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px" id="btn-show-password">
                <svg id="eye-cerrado" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>
                <svg id="eye-abierto" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
            @push('after-script')
            <script>
                $(document).ready(function(){
                    $('#btn-show-password').on('click', function(){
                        if($('#{{$id}}').attr('type') == 'password'){
                            $('#{{$id}}').attr('type', 'text');
                            $('#eye-cerrado').hide();
                            $('#eye-abierto').show();
                        }else{
                            $('#{{$id}}').attr('type', 'password');
                            $('#eye-cerrado').show();
                            $('#eye-abierto').hide();
                        }
                    });
                });
            </script>
            @endpush
        </div>
    @elseif ($type == 'price')
        CULO{{-- <input type="{{$type}}" class="form-control" id="{{$id}}" name="{{$id}}" value="{{ old($id, $attributes['value']) }}" placeholder="{{ $attributes['placeholder'] }}" /> --}}
    @else
        <input type="{{$type}}" class="form-control" id="{{$id}}" name="{{$id}}" value="{{ old($id, $attributes['value']) }}" placeholder="{{ $attributes['placeholder'] }}" />
    @endif
</div>
@error($id)
    <style>
        #{{$id}}{
            border : 1px solid red;
        }
    </style>
    <p class="alert alert-danger py-2 mt-n2">{{$message}}</p>
@enderror