<!-- Create Subject Modal -->
<div class="modal fade" id="createSubjectModel" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Subject</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createSubject" class="createSubject">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="username">Name</label>
                        <input class="form-control" type="text" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="pass_mark">Pass Mark</label>
                        <input class="form-control" type="text" name="pass_mark" id="pass_mark">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="obtained_mark">Obtained Mark</label>
                        <input class="form-control" type="text" name="obtained_mark" id="obtained_mark">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                        </button>
                        <input type="submit" class="btn btn-primary" value="Create Subject">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
