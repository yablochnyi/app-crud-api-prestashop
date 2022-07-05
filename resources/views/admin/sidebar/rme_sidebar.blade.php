<!-- Side navigation -->
<div class="sidenav-rme">
    <div class="action-rme">
        App-RME
    </div>
    <div class="hr-shadow-rme">
        <ul>
            <li>
                <a class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-6"
                   href="{{ route('products.create') }}"> Create Product</a>
            </li>
            <li>
                <form action="{{route('export')}}">
                    <button style="width: 240px"
                            class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2">
                        <div> Export</div>
                        <div class="ml-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" class="fill-current"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.17 5L19 9.83V19H5V5H14.17ZM14.17 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V9.83C21 9.3 20.79 8.79 20.41 8.42L15.58 3.59C15.21 3.21 14.7 3 14.17 3ZM7 15H17V17H7V15ZM7 11H17V13H7V11ZM7 7H14V9H7V7Z"/>
                            </svg>
                        </div>
                    </button>
                </form>
            </li>
            <li>
                <button style="width: 240px"
                        class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2"
                        data-toggle="modal" data-target="#exampleModal">
                    <div> Import</div>
                    <div class="ml-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" class="fill-current"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.17 5L19 9.83V19H5V5H14.17ZM14.17 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V9.83C21 9.3 20.79 8.79 20.41 8.42L15.58 3.59C15.21 3.21 14.7 3 14.17 3ZM7 15H17V17H7V15ZM7 11H17V13H7V11ZM7 7H14V9H7V7Z"/>
                        </svg>
                    </div>
                </button>
            </li>
        </ul>
    </div>
</div>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add file</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
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