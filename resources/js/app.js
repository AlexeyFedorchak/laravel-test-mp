import './bootstrap';

$(document).ready(function() {
    $('#task-form').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: '/tasks',
            type: 'POST',
            data: $(this).serialize(),
            success: function(task) {
                $('#task-list').append(`
                    <tr data-id="${task.id}">
                        <td class="task-title">${task.title}</td>
                        <td class="task-description">${task.description}</td>
                        <td>
                            <button class="btn btn-warning btn-sm toggle-complete">
                                ${task.completed ? 'Mark as Incomplete' : 'Mark as Complete'}
                            </button>
                            <button class="btn btn-info btn-sm edit-task">Edit</button>
                            <button class="btn btn-danger btn-sm delete-task">Delete</button>
                        </td>
                    </tr>
                `);
                $('#task-form')[0].reset();
            },
            error: function(xhr) {
                alert('An error occurred while creating the task.');
            }
        });
    });

    $(document).ready(function() {
        $('#task-list').on('click', '.toggle-complete', function() {
            let $row = $(this).closest('tr');
            let id = $row.data('id');
            let $button = $(this);
            let isCompleted = $button.text().includes('Mark as Complete');

            $.ajax({
                url: `/tasks/${id}`,
                type: 'PUT',
                data: {
                    completed: isCompleted ? 0 : 1,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let newText = response.completed ? 'Mark as Incomplete' : 'Mark as Complete';
                    $button.text(newText);
                },
                error: function(xhr) {
                    alert('An error occurred while updating the task: ' + xhr.responseText);
                }
            });
        });
    });

    $('#task-list').on('click', '.delete-task', function() {
        let $row = $(this).closest('tr');
        let id = $row.data('id');
        $.ajax({
            url: `/tasks/${id}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                $row.remove();
            },
            error: function(xhr) {
                alert('An error occurred while deleting the task.');
            }
        });
    })
    .on('click', '.edit-task', function() {
        let $row = $(this).closest('tr');
        let id = $row.data('id');
        let title = $row.find('.task-title').text();
        let description = $row.find('.task-description').text();

        $('#edit-task-id').val(id);
        $('#edit-title').val(title);
        $('#edit-description').val(description);
        $('#editTaskModal').modal('show');
    });

    $('#edit-task-form').submit(function(event) {
        event.preventDefault();
        let id = $('#edit-task-id').val();
        $.ajax({
            url: `/tasks/${id}`,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(task) {
                let $row = $(`tr[data-id="${task.id}"]`);
                $row.find('.task-title').text(task.title);
                $row.find('.task-description').text(task.description);
                $('#editTaskModal').modal('hide');
            },
            error: function(xhr) {
                alert('An error occurred while updating the task.');
            }
        });
    });
});
