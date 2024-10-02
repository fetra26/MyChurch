<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Federations') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <x-section-border />
            <div class="alert alert-success alert-dismissible fade show" style="display: none">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong class="alert-success-text"></strong>
            </div>
            <div class="mt-10 sm:mt-0 cd__main">
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewFederation" data-bs-toggle="tooltip" title="Nouvelle Federation"><i class="fa fa-plus"></i></a>
                <table class="table table-stripped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>E-mail</th>
                            <th>Téléphone</th>
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
                    <form id="federationForm" name="federationForm" class="form-horizontal">
                       <input type="hidden" name="federation_id" id="federation_id">
                       <input type="hidden" name="contact_id" id="contact_id">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group">
                            <label for="nomFed" class="col-sm control-label">Nom de la federation:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomFed" name="nomFed" value="" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adresse" class="col-sm control-label">Adresse:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="adresse" name="adresse" value="" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm control-label">Email:</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" value="" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telMobile" class="col-sm control-label">Téléphone Mobile:</label>
                            <div class="col-sm-12">
                                <input type="tel" class="form-control" id="telMobile" name="telMobile" value="" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telFixe" class="col-sm control-label">Téléphone fixe:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="telFixe" name="telFixe" value="" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BP" class="col-sm control-label">Boite postal:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="BP" name="BP" value="" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="codePost" class="col-sm control-label">Code postal:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="codePost" name="codePost" value="" maxlength="50">
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
                    <h4 class="modal-title" id="modelHeading"> Details</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Nom de la federation:</strong> <span class="nomFed"></span></p>
                    <p><strong>Adresse:</strong> <span class="adresse"></span></p>
                    <p><strong>Email:</strong> <span class="email"></span></p>
                    <p><strong>Téléphone Mobile:</strong> <span class="telMobile"></span></p>
                    <p><strong>Téléphone fixe:</strong> <span class="telFixe"></span></p>
                    <p><strong>Boite postal:</strong> <span class="BP"></span></p>
                    <p><strong>Code postal:</strong> <span class="codePost"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info mt-2 close" data-bs-dismiss="modal"> Fermer
                    </button>
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
                    <input type="hidden" name="federation_id" id="federation_id">
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
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('federation.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nomFed', name: 'nomFed'},
                {data: 'adresse', name: 'adresse'},
                {data: 'email', name: 'email'},
                {data: 'telMobile', name: 'telMobile'},
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
        $('#createNewFederation').click(function () {
            $('#saveBtn').val("create-federation");
            $('#federation_id').val('');
            $('#federationForm').trigger("reset");
            $('#modelHeading').html(" Créer une nouvelle Federation");
            $('#ajaxModel').modal('show');
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.showFederation', function () {
          var federation_id = $(this).data('id');
          $.get("{{ route('federation.index') }}" +'/' + federation_id, function (data) {


            $('.nomFed').text(data.nomFed);
            $('.adresse').text(data.contact.adresse);
            $('.email').text(data.contact.email);
            $('.telMobile').text(data.contact.telMobile);
            $('.telFixe').text(data.contact.telFixe);
            $('.BP').text(data.contact.BP);
            $('.codePost').text(data.contact.codePost);
            $('#showModel').modal('show');
          })
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editFederation', function () {
          var federation_id = $(this).data('id');
          $.get("{{ route('federation.index') }}" +'/' + federation_id +'/edit', function (data) {
              $('#modelHeading').html(" Modifier la Federation");
              $('#saveBtn').val("edit-federation");
              $('#ajaxModel').modal('show');
              $('#federation_id').val(data.id);
              console.log(data.contact);
              $('#contact_id').val(data.contact.id);
              $('#nomFed').val(data.nomFed);
              $('#adresse').val(data.contact.adresse);
              $('#email').val(data.contact.email);
              $('#telMobile').val(data.contact.telMobile);
              $('#telFixe').val(data.contact.telFixe);
              $('#BP').val(data.contact.BP);
              $('#codePost').val(data.contact.codePost);
          })
        });

        /*------------------------------------------
        --------------------------------------------
        Create federation Code
        --------------------------------------------
        --------------------------------------------*/
        $('#federationForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('federation.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#federationForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          msg = 'Federation ajoutée avec succès.';
                          if($('#saveBtn').val() == 'edit-federation'){
                            msg = 'Federation modifiée avec succès.';
                          }
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#federationForm').find(".print-error-msg").find("ul").html('');
                        $('#federationForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#federationForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });

        /*------------------------------------------
        --------------------------------------------
        Delete federation Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteFederation', function () {
            var federation_id = $(this).data("id");
            $("#federation_id").val(federation_id);
            $('#deleteText').text("Vous voulez vraiment supprimer cette federation?");
            $('#deleteModel').modal('show');
        });
        $('body').on('click', '#deleteBtn', function () {
            var federation_id = $("#federation_id").val();

            $.ajax({
                type: "DELETE",
                url: "{{ route('federation.store') }}"+'/'+federation_id,
                success: function (data) {
                    $('#deleteModel').modal('hide');
                    $(".alert-success-text").text('Federation supprimée avec succès.');
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
