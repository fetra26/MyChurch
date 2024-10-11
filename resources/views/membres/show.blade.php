<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Membres') }}
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
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewMembre" data-bs-toggle="tooltip" title="Nouvelle Membre"><i class="fa fa-plus"></i></a>
                <table class="table table-stripped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Prénom(s)</th>
                            <th>Sexe</th>
                            <th>Né(e) le</th>
                            <th>Eglise</th>
                            <th>Statut</th>
                            <th>Adresse</th>
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
                    <form id="membreForm" name="membreForm" class="form-horizontal">
                       <input type="hidden" name="membre_id" id="membre_id">
                       <input type="hidden" name="contact_id" id="contact_id">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group mt-2" id="DistSelect">
                            <select class="form-select mt-1" aria-label="Default select example" id="eglise_id" name="eglise_id">
                                <option selected value="">Choisir l'eglise</option>
                                @forelse ($eglises as $eglise)
                                    <option value="{{$eglise->id}}">{{$eglise->nomEglise}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nom" class="col-sm control-label">Nom du membre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nom" name="nom" value="" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="prenom" class="col-sm control-label">Prénoms du membre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="prenom" name="prenom" value="" maxlength="50">
                            </div>
                        </div>
                        <label for="">Sexe</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexe" id="sexe0" value="0">
                            <label class="form-check-label" for="sexe0">
                              Femme
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexe" id="sexe1" value="1">
                            <label class="form-check-label" for="sexe1">
                              Homme
                            </label>
                          </div>
                          <label for="">Date de naissance</label>
                        <input id="datepicker" name="datenais"/>
                        {{-- contact --}}
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

                        <div class="form-group mt-1" id="statutSelect">

                            <select class="form-select mt-2 mb-2" aria-label="Default select example" id="status_id" name="status_id">
                                <option selected value="">Choisir le statut</option>
                                @forelse ($status as $statu)
                                    <option value="{{$statu->id}}">{{$statu->libelleStat}}</option>
                                @empty

                                @endforelse
                            </select>
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
                            <label for="nomMembre" class="col-sm control-label">Nom et Prénoms du membre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomMembre" name="nomMembre" maxlength="50" disabled>
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
                        <div class="form-group mt-1" id="pstSelect">
                            
                            <select class="form-select mt-2 mb-2" aria-label="Default select example" id="id_pst" name="id_pst">
                                <option selected value="">Choisir le pasteur</option>
                                @forelse ($pasteurs as $pst)
                                <option value="{{$pst->id}}">{{$pst->nom}} {{$pst->prenom}}</option>
                                @empty
                                
                                @endforelse
                            </select>
                        </div>
                  
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
                            <label for="nomMembreServ" class="col-sm control-label">Nom et Prénoms du membre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomMembreServ" name="nomMembreServ" maxlength="50" disabled>
                            </div>
                        </div>
                       
                        <label for="">Date de début</label>
                        <input id="datepickerDebut" name="dateDebut"/>
                        <label for="">Date de fin</label>
                        <input id="datepickerFin" name="dateFin"/>
                        <div class="form-group mt-1" id="pstSelect">
                            
                            <select class="form-select mt-2 mb-2" aria-label="Default select example" id="id_serv" name="id_serv">
                                <option selected value="">Choisir le service</option>
                                @forelse ($services as $service)
                                <option value="{{$service->id}}">{{$service->nom}} {{$service->libelleServ}}</option>
                                @empty
                                
                                @endforelse
                            </select>
                        </div>
                  
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
            ajax: "{{ route('membre.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nom', name: 'nom'},
                {data: 'prenom', name: 'prenom'},
                {data: 'sexe', name: 'sexe'},
                {data: 'datenais', name: 'datenais'},
                {data: 'nomEglise', name: 'nomEglise'},
                {data: 'libelleStat', name: 'libelleStat'},
                {data: 'adresse', name: 'adresse'},
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
        $('#createNewMembre').click(function () {
            $('#saveBtn').val("create-membre");
            $('#membre_id').val('');
            $('#membreForm').trigger("reset");
            $('#modelHeading').html(" Créer un nouveau Membre");
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
        $('body').on('click', '.showMembre', function () {
          var membre_id = $(this).data('id');
          $.get("{{ route('membre.index') }}" +'/' + membre_id, function (data) {
            
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
            $('.datenais').text(data.datenais);
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
          var membre_id = $(this).data('id');
          $.get("{{ route('membre.index') }}" +'/' + membre_id +'/addBaptism', function (data) {
            console.log(data.nom +' '+ data.prenom);
            
              $('#modelHeadingBapt').html(" Ajouter un bapteme à ce Membre");
              $('#saveBtnBapt').val("add-membre-baptism");
              $('#baptismModel').modal('show');
              $('#membre_id_bapt').val(data.id);
              $('#nomMembre').val(data.nom +' '+ data.prenom);
          })
        });
        /*------------------------------------------
        --------------------------------------------
        Click to add service Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.asignService', function () {
          var membre_id = $(this).data('id');
          $.get("{{ route('membre.index') }}" +'/' + membre_id +'/asignService', function (data) {
            console.log(data.nom +' '+ data.prenom);
            
              $('#modelHeadingServ').html(" Assigner un service à ce Membre");
              $('#saveBtnServ').val("add-membre-service");
              $('#serviceModel').modal('show');
              $('#membre_id_serv').val(data.id);
              $('#nomMembreServ').val(data.nom + (data.prenom ? ' ' + data.prenom : ''));
            })
        });
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editMembre', function () {
          var membre_id = $(this).data('id');
          $.get("{{ route('membre.index') }}" +'/' + membre_id +'/edit', function (data) {
                $('#modelHeading').html(" Modifier la Membre");
                $('#saveBtn').val("edit-membre");
                $('#ajaxModel').modal('show');
                $('#membre_id').val(data.id);
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
        Create membre Code
        --------------------------------------------
        --------------------------------------------*/
        $('#membreForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('membre.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#membreForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          msg = 'Membre ajouté avec succès.';
                          if($('#saveBtn').val() == 'edit-membre'){
                            msg = 'Membre modifié avec succès.';
                          }
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#membreForm').find(".print-error-msg").find("ul").html('');
                        $('#membreForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#membreForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });
        /*------------------------------------------
        --------------------------------------------
        Create membre - baptism Code
        --------------------------------------------
        --------------------------------------------*/
        $('#membreBaptismForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);
            
            $('#saveBtnBapt').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('membre.storeBaptism') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtnBapt').html('Enregistrer');
                          $('#membreBaptismForm').trigger("reset");
                          $('#baptismModel').modal('hide');
                          msg = 'Bapteme ajouté à ce membre avec succès.';
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtnBapt').html('Enregistrer');
                        $('#membreBaptismForm').find(".print-error-msg").find("ul").html('');
                        $('#membreBaptismForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#membreBaptismForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });
        /*------------------------------------------
        --------------------------------------------
        Create membre - service Code
        --------------------------------------------
        --------------------------------------------*/
        $('#membreServiceForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);
            
            $('#saveBtnServ').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('membre.storeService') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtnServ').html('Enregistrer');
                          $('#membreServiceForm').trigger("reset");
                          $('#serviceModel').modal('hide');
                          msg = 'Service assigné à ce membre avec succès.';
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtnServ').html('Enregistrer');
                        $('#membreServiceForm').find(".print-error-msg").find("ul").html('');
                        $('#membreServiceForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#membreServiceForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });

        /*------------------------------------------
        --------------------------------------------
        Delete membre Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteMembre', function () {
            var membre_id = $(this).data("id");
            $("#membre_id").val(membre_id);
            $('#deleteText').text("Vous voulez vraiment supprimer ce membre?");
            $('#deleteModel').modal('show');
        });
        $('body').on('click', '#deleteBtn', function () {
            var membre_id = $("#membre_id").val();

            $.ajax({
                type: "DELETE",
                url: "{{ route('membre.store') }}"+'/'+membre_id,
                success: function (data) {
                    $('#deleteModel').modal('hide');
                    $(".alert-success-text").text('Membre supprimé avec succès.');
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
