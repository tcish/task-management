<x-app-layout>
  @section('title', 'To-do List')
  @push("styles")
    <style>
      .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      #tasks-table th:nth-child(1),
      #tasks-table td:nth-child(1) {
        width: 50px;
      }

      #tasks-table th:nth-child(2),
      #tasks-table td:nth-child(2) {
        width: 120px;
      }

      #tasks-table th:nth-child(3),
      #tasks-table td:nth-child(3) {
        width: 100px;
      }

      #tasks-table th:nth-child(4),
      #tasks-table td:nth-child(4) {
        width: 200px;
      }

      #tasks-table th:nth-child(5),
      #tasks-table td:nth-child(5) {
        width: 120px;
      }

      #tasks-table th:nth-child(6),
      #tasks-table td:nth-child(6) {
        width: 150px;
      }

      #tasks-table th:nth-child(7),
      #tasks-table td:nth-child(7) {
        width: 100px;
      }
    </style>
  @endpush
  <div class="py-4 custom-bg">
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
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                  <!-- Filter -->
                  <select id="statusFilter" class="float-start">
                    <option value="">All</option>
                    <option value="new">New</option>
                    <option selected value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                  </select>
                  <label for="">status filter</label>
                  <!-- Filter End -->
                </div>

                <div>
                  <!-- permission -->
                  @can("is-admin")
                    <x-permission :users="$users" />
                  @endcan
                  <!-- Add Task -->
                  <x-add-task />
                </div>
              </div>

              <!-- Table -->
              <table id="tasks-table" class="display">
                <thead>
                  <tr>
                    <th>ID</th>
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
                      <td>{{ $loop->iteration }}</td> <!-- Incremental ID -->
                      <td class="title-cell" data-full-title="{{ $task->title }}">
                        {{ $task->title }}
                      </td>
                      <td>{{ date("d-m-Y", strtotime($task->due_date)) }}</td>
                      <td class="desc-cell" data-full-desc="{{ $task->desc }}">
                        {{ $task->desc }}
                      </td>
                      <td>
                        <span
                          class="badge rounded-pill bg-{{ $task->status == "new" ? "primary" : ($task->status == "completed" ? "success" : "warning") }}">{{ $task->status }}</span>
                      </td>
                      <td>{{ $task->createdBy->name }}</td>
                      <td class="d-flex">
                        @if ($task->status != "completed")
                          <a href="{{ route("tasks.mark.complete", base64_encode($task->id)) }}"
                            class="btn btn-sm btn-success me-2" data-bs-original-title="tooltip" title="Mark Complete">
                            <i class="bi bi-check-lg"></i>
                          </a>
                        @endif

                        @can("can_assign")
                          <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal"
                            data-bs-target="#taskAssignModal" onclick="assignModal('{{ base64_encode($task->id) }}')"
                            data-bs-original-title="tooltip" title="Assign">
                            <i class="bi bi-plus-lg"></i>
                          </button>
                        @endcan

                        @can("is-admin")
                          <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal"
                            data-bs-target="#taskEditModal" onclick="editTask('{{ base64_encode($task->id) }}')"
                            data-bs-original-title="tooltip" title="Edit">
                            <i class="bi bi-pencil"></i>
                          </button>

                          <form method="post" action="{{ route("tasks.destroy", base64_encode($task->id)) }}"
                            id="deleteTaskForm">
                            @csrf
                            @method("delete")
                            <button type="submit" class="btn btn-sm btn-danger"
                              onclick="return confirm('Are you sure you want to delete this task?')"
                              data-bs-original-title="tooltip" title="Delete">
                              <i class="bi bi-trash2"></i>
                            </button>
                          </form>
                        @endcan
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- Table End -->
            </div>

            <!-- Edit Task -->
            <x-edit-task-modal />
            <!-- Assign Task -->
            <x-assign-task :users="$users" />
          </div>
        </div>
      </div>
    </div>
  </div>

  @push("scripts")
    <script type="module">
      $(document).ready(function() {
        // initialize tooltip
        $('[data-bs-original-title="tooltip"]').tooltip();

        // Hide add task alert after 3 seconds (3000 milliseconds)
        setTimeout(function() {
          $('#add-task-alert').fadeOut('slow', function() {
            $(this).remove(); // removing the alert from DOM after fading out
          });
        }, 3000);

        // Apply to title cells
        truncateAndPopover('.title-cell', 'full-title', 3);

        // Apply to description cells
        truncateAndPopover('.desc-cell', 'full-desc', 4);

        const statusFilterEl = $('#statusFilter');
        let table = $("#tasks-table").DataTable({
          "order": [
            [0, "asc"]
          ], // This ensures the table shows the newest entry on top, based on task id
          columnDefs: [{
              targets: 1,
              orderable: false,
            },
            {
              targets: 1,
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
            },
            {
              targets: 6,
              searchable: false,
              orderable: false,
            }
          ],
        });

        // Custom filtering function
        table.search.fixed('status', function(searchStr, data, index) {
          let selectedStatus = statusFilterEl.val();
          let statusElement = $(data[4]).text().trim(); // Extract text content from the td
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

        // had to make global because vite.js module base execution
        window.editTask = function(taskId) {
          $.ajax({
            type: "get",
            url: "{{ route("tasks.edit", ":taskId") }}".replace(':taskId', taskId),
            success: function(response) {
              // Populate the form fields with response data
              $('#taskEditModal input[name="taskId"]').val(taskId);
              $('#taskEditModal input[name="title"]').val(response.task[0].title);
              $('#taskEditModal input[name="due_date"]').val(response.task[0].due_date);
              $('#taskEditModal select[name="status"]').val(response.task[0].status);
              $('#taskEditModal textarea[name="desc"]').val(response.task[0].desc);
            }
          })
        }

        // setting task id for task assign modal
        window.assignModal = function(taskId) {
          $('#taskAssignModal input[name="task-id"]').val(taskId);
        }
      });

      function truncateAndPopover(selector, dataAttr, wordLimit) {
        $(selector).each(function() {
          var fullText = $(this).data(dataAttr);
          var words = fullText.split(' ');
          var truncated = words.slice(0, wordLimit).join(' ');

          if (words.length > wordLimit) {
            truncated += '...';
            $(this).html('<span class="truncate">' + truncated + '</span>');

            tippy(this, {
              content: fullText,
              allowHTML: true,
              interactive: true,
              delay: [200, 0],
              placement: 'top',
            });
          }
        });
      }
    </script>
  @endpush
</x-app-layout>
