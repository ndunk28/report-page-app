<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Page App</title>
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
</head>
<body>
  <!-- Header -->
  <header>
    <nav class="navbar navbar-dark bg-dark">
      <span class="navbar-brand mb-0 h1">Report Page</span>
    </nav>
  </header>

  <!-- Content -->
  <main class="container mt-4">
    <div class="row pb-2">
      <div class="col">
        <h4>Data Table</h4>
      </div>
      <div class="col text-right">
        <button type="button" id="addModal" class="btn btn-primary mb-3">
          Add New Record
        </button>
      </div>
    </div>
    
    <!-- DataTable will be inserted here -->
    <table id="dataTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be loaded here dynamically -->
      </tbody>
    </table>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center p-3 fixed-bottom">
    <p class="mb-0">&copy; 2024 Report Page App.</p>
  </footer>

  <!-- Modal for Add/Edit -->
  <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Add Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="dataForm">
            <input type="hidden" id="dataId" value="">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 4 and DataTables JS -->
  <script src="assets/js/jquery-3.5.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>

  <script>
      // Dummy JSON data
      let data = [
        { id: 1, name: "Tiger Nixon", email: "tiger@example.com" },
        { id: 2, name: "Garrett Winters", email: "garrett@example.com" },
        { id: 3, name: "Ashton Cox", email: "ashton@example.com" },
        { id: 4, name: "Cedric Kelly", email: "cedric@example.com" },
        { id: 5, name: "Airi Satou", email: "airi@example.com" },
      ];

      // Initialize DataTable
      let table;

      // Function to load data into the DataTable
      function loadTableData() {
        // Destroy previous DataTable if it exists
        if (table) {
          table.clear().destroy();
        }

        let tableBody = $('#dataTable tbody');
        tableBody.empty();
        data.forEach((item, index) => {
          let row = `
            <tr>
                <td>${item.name}</td>
                <td>${item.email}</td>
                <td>
                  <button class="btn btn-primary btn-sm" onclick="openEditModal(${index})">Edit</button>
                  <button class="btn btn-danger btn-sm ml-1" onclick="deleteRow(${index})">Delete</button>
                </td>
            </tr>
          `;
          tableBody.append(row);
        });

        // Reinitialize DataTable after data is updated
        table = $('#dataTable').DataTable({
          paging: true,
          searching: true,
          ordering: true
        });
      }

      // Function to open the modal for adding a new row
      $('#addModal').click(function () {
        $('#modalTitle').text('Add Data');
        $('#dataId').val('');
        $('#name').val('');
        $('#email').val('');
        $('#dataModal').modal('show');
      });

      // Function to open the modal for editing an existing row
      function openEditModal(index) {
        $('#modalTitle').text('Edit Data');
        $('#dataId').val(index);
        $('#name').val(data[index].name);
        $('#email').val(data[index].email);
        $('#dataModal').modal('show');
      }

      // Function to handle form submission
      $('#dataForm').submit(function (event) {
        event.preventDefault();
        let id = $('#dataId').val();
        let name = $('#name').val();
        let email = $('#email').val();

        if (id) {
          // Edit existing data
          data[id].name = name;
          data[id].email = email;
        } else {
          // Add new data
          let newId = data.length + 1;
          data.push({ id: newId, name: name, email: email });
        }

        $('#dataModal').modal('hide');
        loadTableData();
      });

      // Function to delete a row
      function deleteRow(index) {
        if (confirm("Are you sure you want to delete this record?")) {
          data.splice(index, 1);
          loadTableData();
        }
      }

      // Load data when the page is ready
      $(document).ready(function() {
        loadTableData();
      });
  </script>
</body>
</html>
