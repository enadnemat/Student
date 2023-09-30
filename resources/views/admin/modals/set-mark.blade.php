<!-- Create Subject Modal -->
<div class="modal fade" id="setMarkModel" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Set Mark</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="setMark" class="setMark">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="username">Name</label>
                        <select class="form-select" name="id_user">
                            <option selected disabled> Select User</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}"> {{$user->username}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="id_subject">Subject</label>
                        <select class="form-select" name="id_subject">
                            <option selected disabled> Select Subject</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="mark">Mark</label>
                        <input class="form-control" type="number" name="mark" id="mark" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                        </button>
                        <input type="submit" class="btn btn-primary" value="Assign Subject">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
