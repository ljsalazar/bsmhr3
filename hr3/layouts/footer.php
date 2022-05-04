
</div>
</div>
</main>
    <!-- All Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script src="./libs/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./libs/js/jquery-3.5.1.js"></script>
    <script src="./libs/js/jquery.dataTables.min.js"></script>
    <script src="./libs/js/dataTables.bootstrap5.min.js"></script>
    <script src="./libs/js/script.js"></script>
   <!-- End of Script Links -->
              <script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#deleteModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                // $('#recipient-name').val(data[0]);
                $('#d_leavetypes').val(data[1]);
                $('#d_description').val(data[2]);
            });
        });
        var deleteModal = document.getElementById('deleteModal')
                deleteModal.addEventListener('show.bs.modal', function (event) {
                  // Button that triggered the modal
                  var button = event.relatedTarget
                  // Extract info from data-bs-* attributes
                  var recipient = button.getAttribute('data-bs-whatever')
                  // If necessary, you could initiate an AJAX request here
                  // and then do the updating in a callback.
                  //
                  // Update the modal's content.
                  //var modalTitle = deleteModal.querySelector('.modal-title')
                  var modalBodyInput = deleteModal.querySelector('.modal-body input')


                  //modalTitle.textContent = 'New message to ' + recipient
                  modalBodyInput.value = recipient

                })
              </script>
  </body>
</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>
