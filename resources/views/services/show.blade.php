<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services ou Departements') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-screen-2xl mx-auto py-10 sm:px-6 lg:px-8">

            <x-section-border />
            <div class="alert alert-success alert-dismissible fade show" style="display: none">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong class="alert-success-text"></strong>
            </div>
            <div class="mt-10 sm:mt-0 cd__main">
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewservice" data-bs-toggle="tooltip" title="Nouveau service"><i class="fa fa-plus"></i></a>
                <table class="table table-stripped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Libellé</th>
                            <th>Date de création</th>
                            <th>Dernière modification</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="serviceForm" name="serviceForm" class="form-horizontal">
                       <input type="hidden" name="service_id" id="service_id">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group">
                            <label for="libelleServ" class="col-sm control-label">Libellé du service:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="libelleServ" name="libelleServ" value="" maxlength="50" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"> Enregistrer
                        </button>
                        <button type="button" class="btn btn-danger mt-2 close" data-bs-dismiss="modal"> Annuler
                        </button>
                    </div>
                    </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"><i class="fa-regular fa-eye"></i> Show Product</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span class="show-libelleServ"></span></p>
                    <p><strong>Detail:</strong> <span class="show-detail"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"><i class="fa-regular fa-warn"></i> Suppression</h4>
                </div>
                <div class="modal-body">
                    <p><strong id="deleteText"></strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="service_id" id="service_id">
                    <button type="submit" class="btn btn-danger mt-2" id="deleteBtn" value="delete"> Oui
                    </button>
                    <button type="button" class="btn btn-info mt-2 close" data-bs-dismiss="modal"> Non
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
     /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
         $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
        var table = $('.data-table').DataTable({
            language: {
                url: "{{ asset('assets/datatables/fr-FR.json') }}",
                //customize pagination prev and next buttons: use arrows instead of words
                // 'paginate': {
                // 'previous': '<span class="fa fa-chevron-left"></span>',
                // 'next': '<span class="fa fa-chevron-right"></span>'
                // },
                // //customize number of elements to be displayed
                // "lengthMenu": 'Display <select class="form-control input-sm">'+
                // '<option value="10">10</option>'+
                // '<option value="20">20</option>'+
                // '<option value="30">30</option>'+
                // '<option value="40">40</option>'+
                // '<option value="50">50</option>'+
                // '<option value="-1">All</option>'+
                // '</select> results'
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('service.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'libelleServ', name: 'libelleServ'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: true, searchable: true},
            ],

        })

          /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        $('#createNewservice').click(function () {
            $('#saveBtn').val("create-service");
            $('#service_id').val('');
            $('#serviceForm').trigger("reset");
            $('#modelHeading').html(" Créer un nouveau Service");
            $('#ajaxModel').modal('show');
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.showService', function () {
          var service_id = $(this).data('id');
          $.get("{{ route('service.index') }}" +'/' + service_id, function (data) {
              $('#showModel').modal('show');
              $('.show-libelleServ').text(data.libelleServ);
          })
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editService', function () {
          var service_id = $(this).data('id');
          $.get("{{ route('service.index') }}" +'/' + service_id +'/edit', function (data) {
              $('#modelHeading').html(" Modifier le Service");
              $('#saveBtn').val("edit-service");
              $('#ajaxModel').modal('show');
              $('#service_id').val(data.id);
              $('#libelleServ').val(data.libelleServ);
          })
        });

        /*------------------------------------------
        --------------------------------------------
        Create service Code
        --------------------------------------------
        --------------------------------------------*/
        $('#serviceForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('service.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#serviceForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          msg = 'Service ajouté avec succès.';
                          if($('#saveBtn').val() == 'edit-service'){
                            msg = 'Service modifié avec succès.';
                          }
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#serviceForm').find(".print-error-msg").find("ul").html('');
                        $('#serviceForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#serviceForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });

        /*------------------------------------------
        --------------------------------------------
        Delete service Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteService', function () {
            var service_id = $(this).data("id");
            $("#service_id").val(service_id);
            $('#deleteText').text("Vous voulez vraiment supprimer ce service?");
            $('#deleteModel').modal('show');
        });
        $('body').on('click', '#deleteBtn', function () {
            var service_id = $("#service_id").val();

            $.ajax({
                type: "DELETE",
                url: "{{ route('service.store') }}"+'/'+service_id,
                success: function (data) {
                    $('#deleteModel').modal('hide');
                    $(".alert-success-text").text('Service supprimé avec succès.');
                    $(".alert-success").show();
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        });
        });
    </script>
</x-app-layout>
