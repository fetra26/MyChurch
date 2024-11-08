<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transferts') }}
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
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewTransfert" data-bs-toggle="tooltip" title="Nouvelle demande de Transfert"><i class="fa fa-plus"></i></a>
                <table class="table table-stripped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom et Prénom(s) du membre</th>
                            <th>Eglise demandeur</th>
                            <th>Eglise recepteur</th>
                            <th>Date de demande</th>
                            <th>Date de reponse</th>
                            <th>Reponse</th>
                            <th>Responsable demandeur</th>
                            <th>Responsable recepteur</th>
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
                    <form id="transfertForm" name="transfertForm" class="form-horizontal">
                       <input type="hidden" name="transfert_id" id="transfert_id">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group mt-2" id="sourceSelect">
                            <select class="form-select mt-1" aria-label="Default select example" id="egliseSource_id" name="egliseSource_id" required>
                                <option selected value="">Choisir l'eglise recepteur</option>
                                @forelse ($egliseSources as $egliseSource)
                                    <option value="{{$egliseSource->id}}">{{$egliseSource->nomEglise}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group mt-2" id="membreSelect">
                            <select class="form-select mt-1" aria-label="Default select example" id="membre_id" name="membre_id" required>
                                <option selected value="">Choisir le membre</option>
                                @forelse ($membres as $membre)
                                    <option value="{{$membre->id}}">{{$membre->nom}} {{$membre->prenom}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group mt-2" id="membreSelect">
                            <select class="form-select mt-1" aria-label="Default select example" id="pstOrLhl_id" name="pstOrLhl_id" required>
                                <option selected value="">Choisir le Pasteur/Loholona de votre Eglise </option>
                                @forelse ($pasteurs as $pasteur)
                                    <option value="{{$pasteur->id}}">{{$pasteur->full_name}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"> Envoyer
                        </button>
                        <button type="button" class="btn btn-danger mt-2 close" data-bs-dismiss="modal"> Annuler
                        </button>
                    </div>
                    </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="baptismModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingBapt"></h4>
                </div>
                <div class="modal-body">
                    <form id="membreBaptismForm" name="membreBaptismForm" class="form-horizontal">
                       <input type="hidden" name="membre_id" id="membre_id_bapt">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="form-group">
                            <label for="nomTransfert" class="col-sm control-label">Nom et Prénoms du membre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomTransfert" name="nomTransfert" maxlength="50" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lieuBapt" class="col-sm control-label">Lieu du bapteme:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="lieuBapt" name="lieuBapt" value="" maxlength="50">
                            </div>
                        </div>

                        <label for="">Date du bapteme</label>
                      <input id="datepicker1" name="dateBapt"/>
                        {{-- <div class="form-group mt-1" id="pstSelect">

                            <select class="form-select mt-2 mb-2" aria-label="Default select example" id="id_pst" name="id_pst">
                                <option selected value="">Choisir le pasteur</option>
                                @forelse ($pasteurs as $pst)
                                <option value="{{$pst->id}}">{{$pst->nom}} {{$pst->prenom}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div> --}}

                        <div class="form-group mb-3">
                            <label for="messageBapt" class="form-label">Message du bapteme</label>
                            <textarea class="form-control" id="messageBapt" name="messageBapt" rows="3"></textarea>
                          </div>
                        <label for="">Certificat</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="delivered" id="delivered0" value="0">
                            <label class="form-check-label" for="delivered0">
                              Délivré
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="delivered" id="delivered1" value="1">
                            <label class="form-check-label" for="delivered1">
                              Non délivré
                            </label>
                          </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success mt-2" id="saveBtnBapt" value="create"> Enregistrer
                        </button>
                        <button type="button" class="btn btn-danger mt-2 close" data-bs-dismiss="modal"> Annuler
                        </button>
                    </div>
                    </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="serviceModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingServ"></h4>
                </div>
                <div class="modal-body">
                    <form id="membreServiceForm" name="membreServiceForm" class="form-horizontal">
                       <input type="hidden" name="membre_id" id="membre_id_serv">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="form-group">
                            <label for="nomTransfertServ" class="col-sm control-label">Nom et Prénoms du membre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomTransfertServ" name="nomTransfertServ" maxlength="50" disabled>
                            </div>
                        </div>

                        <label for="">Date de début</label>
                        <input id="datepickerDebut" name="dateDebut" required/>
                        <label for="">Date de fin</label>
                        <input id="datepickerFin" name="dateFin" required/>
                        {{-- <div class="form-group mt-1" id="servSelect">

                            <select class="form-select mt-2 mb-2" aria-label="Default select example" id="id_serv" name="id_serv">
                                <option selected value="">Choisir le service</option>
                                @forelse ($services as $service)
                                <option value="{{$service->id}}">{{$service->libelleServ}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div> --}}
                        {{-- <div class="form-group mt-1" id="roleSelect">

                            <select class="form-select mt-2 mb-2" aria-label="Default select example" id="role_id" name="role_id">
                                <option selected value="">Choisir le rôle</option>
                                @forelse ($roles as $role)
                                <option value="{{$role->id}}">{{$role->libelleRole}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div> --}}

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success mt-2" id="saveBtnServ" value="create"> Enregistrer
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
                    <p class="nomEglise"><strong>Nom de l'eglise:</strong> <span class="eglise_id"></span></p>
                    <p class=""><strong>Nom du membre:</strong> <span class="nom"></span></p>
                    <p class=""><strong>Prénoms du membre:</strong> <span class="prenom"></span></p>
                    <p class=""><strong>Sexe:</strong> <span class="sexe"></span></p>
                    <p class=""><strong>Date de naissance:</strong> <span class="datenais"></span></p>
                    <p class=""><strong>Adresse:</strong> <span class="adresse"></span></p>
                    <p class=""><strong>Email:</strong> <span class="email"></span></p>
                    <p class=""><strong>Téléphone Mobile:</strong> <span class="telMobile"></span></p>
                    <p class=""><strong>Téléphone fixe:</strong> <span class="telFixe"></span></p>
                    <p class=""><strong>Boite postal:</strong> <span class="BP"></span></p>
                    <p class=""><strong>Code postal:</strong> <span class="codePost"></span></p>
                    <p class="libelleStat"><strong>statut:</strong> <span class="status_id"></span></p>
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
                    <input type="hidden" name="membre_id" id="membre_id">
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
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap5',
                locale: 'fr-fr',
                format: 'dd/mm/yyyy'
            });
            $('#datepicker1').datepicker({
                uiLibrary: 'bootstrap5',
                locale: 'fr-fr',
                format: 'dd/mm/yyyy'
            });
            $('#datepickerDebut').datepicker({
                uiLibrary: 'bootstrap5',
                locale: 'fr-fr',
                format: 'dd/mm/yyyy'
            });
            $('#datepickerFin').datepicker({
                uiLibrary: 'bootstrap5',
                locale: 'fr-fr',
                format: 'dd/mm/yyyy'
            });
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
            ajax: "{{ route('transfert.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nomComplet', name: 'nomComplet'},
                {data: 'destination', name: 'destination'},
                {data: 'source', name: 'source'},
                {data: 'dateDemande', name: 'dateDemande'},
                {data: 'dateReponse', name: 'dateReponse'},
                {data: 'status', name: 'status'},
                {data: 'responsableDestination', name: 'responsableDestination'},
                {data: 'responsableSource', name: 'responsableSource'},
                {data: 'action', name: 'action', orderable: true, searchable: true},
            ],

        })

          /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        $('#createNewTransfert').click(function () {
            $('#saveBtn').val("create-transfert");
            $('#transfert_id').val('');
            $('#transfertForm').trigger("reset");
            $('#modelHeading').html(" Envoyer une demande de Transfert");
            $('#ajaxModel').modal('show');
        });

        $('#ajaxModel').on('hidden.bs.modal', function () {
            $('.print-error-msg').hide();
        })
        $('#baptismModel').on('hidden.bs.modal', function () {
            $('.print-error-msg').hide();
        })
        $('#serviceModel').on('hidden.bs.modal', function () {
            $('.print-error-msg').hide();
        })
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.showTransfert', function () {
          var transfert_id = $(this).data('id');
          $.get("{{ route('transfert.index') }}" +'/' + transfert_id, function (data) {

            if (data.eglise) {
                $('.nomEglise').show();
                  $('.eglise_id').text(data.eglise.nomEglise);
                }
              if (data.status) {
                $('.libelleStat').show();
                  $('.status_id').text(data.status.libelleStat);
                }
            $('.nom').text(data.nom);
            $('.prenom').text(data.prenom);
            $('.sexe').text((data.sexe == 0) ? 'Femme' : 'Homme');

            let dateStr = data.datenais;
            let dateParts = dateStr.split('-');
            let formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
            $('.datenais').text(formattedDate);

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
        $('body').on('click', '.addBaptism', function () {
          var transfert_id = $(this).data('id');
          $.get("{{ route('transfert.index') }}" +'/' + transfert_id +'/addBaptism', function (data) {
            console.log(data.nom +' '+ data.prenom);

              $('#modelHeadingBapt').html(" Ajouter un bapteme à ce Transfert");
              $('#saveBtnBapt').val("add-transfert-baptism");
              $('#baptismModel').modal('show');
              $('#transfert_id_bapt').val(data.id);
              $('#nomTransfert').val(data.nom +' '+ data.prenom);
          })
        });
        /*------------------------------------------
        --------------------------------------------
        Click to add service Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.asignService', function () {
          var transfert_id = $(this).data('id');
          $.get("{{ route('transfert.index') }}" +'/' + transfert_id +'/asignService', function (data) {
            console.log(data.nom +' '+ data.prenom);

              $('#modelHeadingServ').html(" Assigner un service à ce Transfert");
              $('#saveBtnServ').val("add-transfert-service");
              $('#serviceModel').modal('show');
              $('#transfert_id_serv').val(data.id);
              $('#nomTransfertServ').val(data.nom + (data.prenom ? ' ' + data.prenom : ''));
            })
        });
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editTransfert', function () {
          var transfert_id = $(this).data('id');
          $.get("{{ route('transfert.index') }}" +'/' + transfert_id +'/edit', function (data) {
                $('#modelHeading').html(" Modifier la Transfert");
                $('#saveBtn').val("edit-transfert");
                $('#ajaxModel').modal('show');
                $('#transfert_id').val(data.id);
                if (data.eglise) {
                    $('#eglise_id').val(data.eglise.id);
                }
                if (data.status ) {
                    $('#status_id').val(data.status.id);
                }
                $('#contact_id').val(data.contact.id);
                $('#nom').val(data.nom);
                $('#prenom').val(data.prenom);
                // Assuming data.sexe contains either '0' for Femme or '1' for Homme
                var sexeValue = data.sexe; // e.g., '0' or '1'

                // Set the corresponding radio button based on the value of sexe
                if (sexeValue == '0') {
                    $('#sexe0').prop('checked', true); // Select Femme
                } else if (sexeValue == '1') {
                    $('#sexe1').prop('checked', true); // Select Homme
                }
                                // Assuming data.datenais is in the 'Y-m-d' format
                var datenais = data.datenais; // e.g., '2024-10-09'

                // Convert 'Y-m-d' to 'dd/mm/yyyy'
                var dateParts = datenais.split('-');
                var formattedDate = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0]; // 'dd/mm/yyyy'

                // Set the value in the datepicker
                $('#datepicker').val(formattedDate);
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
        Create transfert Code
        --------------------------------------------
        --------------------------------------------*/
        $('#transfertForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('transfert.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#transfertForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          msg = 'Transfert ajouté avec succès.';
                          if($('#saveBtn').val() == 'edit-transfert'){
                            msg = 'Transfert modifié avec succès.';
                          }
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#transfertForm').find(".print-error-msg").find("ul").html('');
                        $('#transfertForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#transfertForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });
        /*------------------------------------------
        --------------------------------------------
        Create transfert - baptism Code
        --------------------------------------------
        --------------------------------------------*/
        $('#transfertBaptismForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);

            $('#saveBtnBapt').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('transfert.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtnBapt').html('Enregistrer');
                          $('#transfertBaptismForm').trigger("reset");
                          $('#baptismModel').modal('hide');
                          msg = 'Bapteme ajouté à ce transfert avec succès.';
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtnBapt').html('Enregistrer');
                        $('#transfertBaptismForm').find(".print-error-msg").find("ul").html('');
                        $('#transfertBaptismForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#transfertBaptismForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });
        /*------------------------------------------
        --------------------------------------------
        Create transfert - service Code
        --------------------------------------------
        --------------------------------------------*/
        $('#transfertServiceForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);

            $('#saveBtnServ').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('transfert.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtnServ').html('Enregistrer');
                          $('#transfertServiceForm').trigger("reset");
                          $('#serviceModel').modal('hide');
                          msg = 'Service assigné à ce transfert avec succès.';
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtnServ').html('Enregistrer');
                        $('#transfertServiceForm').find(".print-error-msg").find("ul").html('');
                        $('#transfertServiceForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#transfertServiceForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });

        /*------------------------------------------
        --------------------------------------------
        Delete transfert Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteTransfert', function () {
            var transfert_id = $(this).data("id");
            $("#transfert_id").val(transfert_id);
            $('#deleteText').text("Vous voulez vraiment supprimer ce transfert?");
            $('#deleteModel').modal('show');
        });
        $('body').on('click', '#deleteBtn', function () {
            var transfert_id = $("#transfert_id").val();

            $.ajax({
                type: "DELETE",
                url: "{{ route('transfert.store') }}"+'/'+transfert_id,
                success: function (data) {
                    $('#deleteModel').modal('hide');
                    $(".alert-success-text").text('Transfert supprimé avec succès.');
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
