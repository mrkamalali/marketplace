@if(Session::has('success'))
    <div class="row mr-2 ml-2 alert" >
            <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                    id="type-error">{{Session::get('success')}}
            </button>
    </div>
    <script>
        $('div.alert').delay(300).slideDown(300);
    </script>

@endif
