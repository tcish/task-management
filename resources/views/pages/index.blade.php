<x-app-layout>
  <div class="py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          @if (session("success"))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="add-task-alert">
              {{ session("success") }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="card shadow-sm">
            <div class="card-body text-dark overflow-auto">
              <!-- Add Task -->
              <x-add-task />

              <!-- Filter -->
              <select id="statusFilter" class="float-start">
                <option value="">All</option>
                <option value="new">New</option>
                <option selected value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
              <label for="">status filter</label>
              <!-- Filter End -->

              <!-- Table -->
              <table id="tasks-table" class="display">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Due Date</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Added By</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tasks as $task)
                    <tr>
                      <td>{{ $task->title }}</td>
                      <td>{{ date("d-m-Y", strtotime($task->due_date)) }}</td>
                      <td>{{ $task->desc }}</td>
                      <td>
                        <span
                          class="badge rounded-pill bg-{{ $task->status == "new" ? "primary" : ($task->status == "completed" ? "success" : "warning") }}">{{ $task->status }}</span>
                      </td>
                      <td>{{ $task->createdBy->name }}</td>
                      <td class="d-flex">
                        <a href="" class="btn btn-sm btn-secondary me-2">Assign</a>
                        <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal"
                          data-bs-target="#taskEditModal"
                          onclick="editTask('{{ base64_encode($task->id) }}')">Edit</button>
                        <form method="post" action="{{ route("tasks.destroy", base64_encode($task->id)) }}"
                          id="deleteTaskForm">
                          @csrf
                          @method("delete")
                          <button type="submit" class="btn btn-sm btn-danger" id="deleteTaskButton">Delete</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- Table End -->
            </div>

            <!-- Edit Task -->
            <x-edit-task-modal />
          </div>
        </div>
      </div>
    </div>
  </div>

  @push("scripts")
    <script type="module">
      $(document).ready(function() {
        // Hide add task alert after 3 seconds (3000 milliseconds)
        setTimeout(function() {
          $('#add-task-alert').fadeOut('slow', function() {
            $(this).remove(); // removing the alert from DOM after fading out
          });
        }, 3000);

        const statusFilterEl = $('#statusFilter');
        let table = $("#tasks-table").DataTable({
          columnDefs: [{
              targets: 0,
              orderable: false,
            },
            {
              targets: 2,
              searchable: false,
              orderable: false,
            },
            {
              targets: 3,
              searchable: false,
              orderable: false,
            },
            {
              targets: 4,
              searchable: false,
              orderable: false,
            },
            {
              targets: 5,
              searchable: false,
              orderable: false,
            }
          ],
        });

        // Custom filtering function
        table.search.fixed('status', function(searchStr, data, index) {
          let selectedStatus = statusFilterEl.val();
          let statusElement = $(data[3]).text().trim(); // Extract text content from the span
          let normalizedStatus = statusElement.toLowerCase();

          if (selectedStatus === '' || normalizedStatus === selectedStatus) {
            return true;
          }

          return false;
        });

        // Changes to the dropdown will trigger a redraw to update the table
        statusFilterEl.on('change', function() {
          table.draw();
        });

        // Trigger initial filter based on default selected filter value
        table.draw();

        window.editTask = function(taskId) {
          $.ajax({
            type: "get",
            url: "{{ route("tasks.edit", ":taskId") }}".replace(':taskId', taskId),
            success: function(response) {
              // Populate the form fields with response data
              $('#taskEditModal input[name="taskId"]').val(response.task[0].id);
              $('#taskEditModal input[name="title"]').val(response.task[0].title);
              $('#taskEditModal input[name="due_date"]').val(response.task[0].due_date);
              $('#taskEditModal select[name="status"]').val(response.task[0].status);
              $('#taskEditModal textarea[name="desc"]').val(response.task[0].desc);
            }
          })
        }

        $('#deleteTaskButton').on('click', function(event) {
          event.preventDefault();
          if (confirm("Are you sure you want to delete this task?")) {
            $("#deleteTaskForm").submit();
          }
        });
      });
    </script>
  @endpush
</x-app-layout>
