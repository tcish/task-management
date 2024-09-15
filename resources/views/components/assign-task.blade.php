  <!-- Modal -->
  <div class="modal fade" id="taskAssignModal" tabindex="-1" aria-labelledby="taskAssignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="taskAssignModalLabel">Assign Task</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route("assigns.store") }}" id="assignTaskForm"
            class="row g-3 needs-assign-form-validation" novalidate>
            @csrf

            <input type="hidden" name="task-id" id="task-id">

            <div class="col-12">
              <label for="assign_to" class="form-label">Assign to</label>
              <select class="form-select" name="assign_to" id="assign_to" required>
                <option selected disabled value="">Select user...</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">Please select a user.</div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="assignTaskFormSubmit" class="btn btn-sm btn-primary">Submit</button>
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
        $('.needs-assign-form-validation').each(function() {
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
      $('#assignTaskFormSubmit').on('click', function(event) {
        if (!validateForms()) {
          event.preventDefault();
        } else {
          $("#assignTaskForm").submit();
        }
      });

      // check for duplicate assignee
      $("#assign_to").on("change", function() {
        let task_id = $("#task-id").val();
        let user_id = $("#assign_to").val();

        $.ajax({
          type: "get",
          url: "{{ route("assigns.check", [":taskId", ":userId"]) }}"
            .replace(':taskId', task_id)
            .replace(':userId', user_id),
          success: function(response) {
            if (response.status) {
              $('.invalid-feedback').show();
              $('.invalid-feedback').text(response.message);
              $('#assignTaskFormSubmit').prop('disabled', true);
            } else {
              $('.invalid-feedback').hide();
              $('.invalid-feedback').text("");
              $('#assignTaskFormSubmit').prop('disabled', false);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error: " + textStatus + ": " + errorThrown);
          }
        })
      })
    </script>
  @endpush
