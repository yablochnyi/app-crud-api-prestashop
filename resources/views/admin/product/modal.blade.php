<x-filament::button>
<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (count($errors) > 0)
        <div class="row">
            <div class="col-md-offset-1">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    @foreach($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="file" name="import"/>
                </div>
                <div class="modal-footer">
                    <a type="submit" class="btn btn-danger" data-dismiss="modal">Close</a>
                    <input type="submit" class="btn btn-custom-success" value="Add"/>
                </div>
            </div>
        </div>
    </div>
</form>
</x-filament::button>
