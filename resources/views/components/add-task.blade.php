  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary mb-1 float-end" data-bs-toggle="modal" data-bs-target="#taskModal">Add
    task</button>

  <!-- Modal -->
  <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="taskModalLabel">Add Task</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route("tasks.store") }}" id="taskForm" class="row g-3 needs-validation"
            novalidate>
            @csrf
            <!-- Title input -->
            <div class="col-12 mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" name="title" required>
              <div class="invalid-feedback">Please select task title.</div>
            </div>

            <!-- Due Date and Status input-->
            <div class="col-12 col-md-6 mb-3">
              <label for="due_date" class="form-label">Due date</label>
              <input type="date" class="form-control" name="due_date" required>
              <div class="invalid-feedback">Please select due date.</div>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" name="status" required>
                <option selected disabled value="">Choose...</option>
                <option value="new">New</option>
                <option value="in-progress">In-progress</option>
                <option value="completed">Completed</option>
              </select>
              <div class="invalid-feedback">Please select a status.</div>
            </div>

            <!-- Description textarea -->
            <div class="col-12 mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="desc" placeholder="Leave a description here"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="taskFormSubmit" class="btn btn-sm btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal End -->

  @push("scripts")
    <script type="module">
      // Function to validate all forms
      function validateForms() {
        let isValid = true;

        // Loop over forms and check validity
        $('.needs-validation').each(function() {
          const form = $(this);
          if (!form[0].checkValidity()) {
            isValid = false;
            form.addClass('was-validated');
          } else {
            form.removeClass('was-validated');
          }
        });

        return isValid;
      }

      // Attach event listener to the submit button
      $('#taskFormSubmit').on('click', function(event) {
        if (!validateForms()) {
          event.preventDefault();
        } else {
          $("#taskForm").submit();
        }
      });
    </script>
  @endpush
