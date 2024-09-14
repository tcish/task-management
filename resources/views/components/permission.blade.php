<button type="button" class="btn btn-dark me-2 float-end" data-bs-toggle="modal"
  data-bs-target="#permissionModal">Permissions</button>

<!-- Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="permissionModalLabel">Permission</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route("permissions.store") }}" id="permissionForm"
          class="row g-3 needs-permission-form-validation" novalidate>
          @csrf

          <div class="col-12">
            <label for="permit_to" class="form-label">Permission to</label>
            <select class="form-select" name="permit_to" id="permit_to" required>
              <option selected disabled value="">Select user...</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">Please select a user.</div>
          </div>

          <div class="col-12">
            <label for="permission_name" class="form-label">Permissions</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="permission[]" id="can_assign" value="can_assign" />
              <label class="form-check-label" for="can_assign">Can Assign</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="permission[]" id="can_create" value="can_create" />
              <label class="form-check-label" for="can_create">Can Create</label>
            </div>

            <div id="checkboxError" class="invalid-feedback" style="display:none;">
              Please select at least one permission.
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="permissionFormSubmit" class="btn btn-sm btn-primary">Submit</button>
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
      $('.needs-permission-form-validation').each(function() {
        const form = $(this);

        // Check if at least one checkbox is checked
        const checkboxes = form.find('input[name="permission[]"]');
        const isChecked = checkboxes.is(':checked');

        if (!isChecked) {
          isValid = false;
          $('#checkboxError').show();
          checkboxes.each(function() {
            $(this).addClass('is-invalid');
          });
        } else {
          $('#checkboxError').hide();
          checkboxes.each(function() {
            $(this).removeClass('is-invalid');
          });
        }

        // Check overall form validity
        if (!form[0].checkValidity() || !isChecked) {
          isValid = false;
          form.addClass('was-validated');
        } else {
          form.removeClass('was-validated');
        }
      });

      return isValid;
    }

    // Attach event listener to the submit button
    $('#permissionFormSubmit').on('click', function(event) {
      if (!validateForms()) {
        event.preventDefault();
      } else {
        $("#permissionForm").submit();
      }
    });

    // check for duplicate assignee
    $("#permit_to").on("change", function() {
      let user_id = $("#permit_to").val();
      $('#can_assign').prop('checked', false);
      $('#can_create').prop('checked', false);

      $.ajax({
        type: "get",
        url: "{{ route("permissions.userId", ":userId") }}".replace(':userId', user_id),
        success: function(response) {
          if (response.status) {
            if (response.permission.can_assign) {
              $('#can_assign').prop('checked', true);
            }
            if (response.permission.can_create) {
              $('#can_create').prop('checked', true);
            }
          }
        }
      })
    })
  </script>
@endpush
