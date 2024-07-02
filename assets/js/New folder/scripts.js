$(document).ready(function() {
    // Add student
    $('#addStudentForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_student.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Success', response.message, 'success');
                    $('#addStudentForm')[0].reset();
                    loadStudents(); // Reload students for the dropdown
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

    // Add fee
    $('#manageFeeForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_fee.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Success', response.message, 'success');
                    $('#manageFeeForm')[0].reset();
                    loadFees(); // Reload fees table
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

    // Load existing fees
    function loadFees() {
        $.ajax({
            url: 'ajax/get_fees.php',
            type: 'GET',
            success: function(response) {
                var fees = JSON.parse(response);
                var tbody = '';
                $.each(fees, function(index, fee) {
                    tbody += '<tr>';
                    tbody += '<td>' + fee.name + '</td>';
                    tbody += '<td>' + fee.amount + '</td>';
                    tbody += '<td>' + fee.month + '</td>';
                    tbody += '<td>' + fee.status + '</td>';
                    tbody += '<td><button class="btn btn-primary edit-fee" data-id="' + fee.id + '">Edit</button></td>';
                    tbody += '<td><button class="btn btn-danger delete-fee" data-id="' + fee.id + '">Delete</button></td>';
                    tbody += '</tr>';
                });
                $('#feeTable tbody').html(tbody);
            }
        });
    }

    // Load students for the dropdown
    function loadStudents() {
        $.ajax({
            url: 'ajax/get_students.php',
            type: 'GET',
            success: function(response) {
                var students = JSON.parse(response);
                var options = '<option value="">Select Student</option>';
                $.each(students, function(index, student) {
                    options += '<option value="' + student.id + '">' + student.name + '</option>';
                });
                $('#student_id').html(options);
            }
        });
    }

    // Delete fee
    $('#feeTable').on('click', '.delete-fee', function() {
        const fee_id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'ajax/delete_fee.php',
                    type: 'POST',
                    data: { fee_id: fee_id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success');
                            loadFees(); // Reload fees table
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                });
            }
        });
    });

    // Edit student
    $('#studentTable').on('click', '.edit-student', function() {
        const student_id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_student.php',
            type: 'POST',
            data: { student_id: student_id },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const student = response.data;
                    $('#editStudentForm [name="student_id"]').val(student.id);
                    $('#editStudentForm [name="name"]').val(student.name);
                    $('#editStudentForm [name="email"]').val(student.email);
                    $('#editStudentForm [name="phone"]').val(student.phone);
                    $('#editStudentForm [name="address"]').val(student.address);
                    $('#editStudentForm [name="class"]').val(student.class);
                    $('#editStudentForm [name="section"]').val(student.section);
                    $('#editStudentModal').modal('show');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

    // Update student
    $('#editStudentForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/update_student.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Success', response.message, 'success');
                    $('#editStudentModal').modal('hide');
                    loadStudents(); // Reload students for the table
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

    // Edit fee
    $('#feeTable').on('click', '.edit-fee', function() {
        const fee_id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_fee.php',
            type: 'POST',
            data: { fee_id: fee_id },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const fee = response.data;
                    $('#editFeeForm [name="fee_id"]').val(fee.id);
                    $('#editFeeForm [name="student_id"]').val(fee.student_id);
                    $('#editFeeForm [name="amount"]').val(fee.amount);
                    $('#editFeeForm [name="month"]').val(fee.month);
                    $('#editFeeForm [name="status"]').val(fee.status);
                    $('#editFeeModal').modal('show');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

    // Update fee
    $('#editFeeForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/update_fee.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Success', response.message, 'success');
                    $('#editFeeModal').modal('hide');
                    loadFees(); // Reload fees table
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

    // Load initial data
    loadFees();
    loadStudents();
});
