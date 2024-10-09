<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Missions') }}
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
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewMission" data-bs-toggle="tooltip" title="Nouvelle Mission"><i class="fa fa-plus"></i></a>
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
                    <form id="missionForm" name="missionForm" class="form-horizontal">
                       <input type="hidden" name="mission_id" id="mission_id">
                       <input type="hidden" name="contact_id" id="contact_id">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group">
                            <label for="nomMiss" class="col-sm control-label">Nom de la mission:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomMiss" name="nomMiss" value="" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adresse" class="col-sm control-label">Adresse:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="adresse" name="adresse" value="" maxlength="50" required>
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
   <div class="modal fade" id="districtModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingDist"></h4>
                </div>
                <div class="modal-body">
                    <form id="districtFedForm" name="districtFedForm" class="form-horizontal">
                       <input type="hidden" name="mission_id" id="mission_id_dist">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group">
                            <label for="nomMiss" class="col-sm control-label">Nom de la mission:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomMissDist" name="nomMiss" value="" maxlength="50" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nomDist" class="col-sm control-label">Nom du district:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomDist" name="nomDist" value="" maxlength="50" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success mt-2" id="saveBtnDist" value="create"> Enregistrer
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
                    <p><strong>Nom de la mission:</strong> <span class="nomMiss"></span></p>
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
                    <input type="hidden" name="mission_id" id="mission_id">
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
            ajax: "{{ route('mission.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nomMiss', name: 'nomMiss'},
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
        $('#createNewMission').click(function () {
            $('#saveBtn').val("create-mission");
            $('#mission_id').val('');
            $('#missionForm').trigger("reset");
            $('#modelHeading').html(" Créer une nouvelle Mission");
            $('#ajaxModel').modal('show');
        });

        $('#ajaxModel').on('hidden.bs.modal', function () {
            $('.print-error-msg').hide();
        })
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.showMission', function () {
          var mission_id = $(this).data('id');
          $.get("{{ route('mission.index') }}" +'/' + mission_id, function (data) {
            $('.nomMiss').text(data.nomMiss);
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
        Click to add disctrict Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.addDistrict', function () {
          var mission_id = $(this).data('id');
          $.get("{{ route('mission.index') }}" +'/' + mission_id +'/addDistrict', function (data) {
              $('#modelHeadingDist').html(" Ajouter un district à cette Mission");
              $('#saveBtnDist').val("add-district-mission");
              $('#districtModel').modal('show');
              $('#mission_id_dist').val(data.id);
              $('#nomMissDist').val(data.nomMiss);
          })
        });
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editMission', function () {
          var mission_id = $(this).data('id');
          $.get("{{ route('mission.index') }}" +'/' + mission_id +'/edit', function (data) {
              $('#modelHeading').html(" Modifier la Mission");
              $('#saveBtn').val("edit-mission");
              $('#ajaxModel').modal('show');
              $('#mission_id').val(data.id);
              console.log(data.contact);
              $('#contact_id').val(data.contact.id);
              $('#nomMiss').val(data.nomMiss);
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
        Create mission Code
        --------------------------------------------
        --------------------------------------------*/
        $('#missionForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('mission.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#missionForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          msg = 'Mission ajoutée avec succès.';
                          if($('#saveBtn').val() == 'edit-mission'){
                            msg = 'Mission modifiée avec succès.';
                          }
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#missionForm').find(".print-error-msg").find("ul").html('');
                        $('#missionForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#missionForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });
/*------------------------------------------
        --------------------------------------------
        Create district - federation Code
        --------------------------------------------
        --------------------------------------------*/
        $('#districtFedForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);
            
            $('#saveBtnDist').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('mission.storeDistrict') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtnDist').html('Enregistrer');
                          $('#districtFedForm').trigger("reset");
                          $('#districtModel').modal('hide');
                          msg = 'District ajouté à cette mission avec succès.';
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtnDist').html('Enregistrer');
                        $('#districtFedForm').find(".print-error-msg").find("ul").html('');
                        $('#districtFedForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#districtFedForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });
        /*------------------------------------------
        --------------------------------------------
        Delete mission Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteMission', function () {
            var mission_id = $(this).data("id");
            $("#mission_id").val(mission_id);
            $('#deleteText').text("Vous voulez vraiment supprimer cette mission?");
            $('#deleteModel').modal('show');
        });
        $('body').on('click', '#deleteBtn', function () {
            var mission_id = $("#mission_id").val();

            $.ajax({
                type: "DELETE",
                url: "{{ route('mission.store') }}"+'/'+mission_id,
                success: function (data) {
                    $('#deleteModel').modal('hide');
                    $(".alert-success-text").text('Mission supprimée avec succès.');
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
