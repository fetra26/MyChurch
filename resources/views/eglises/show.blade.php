<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eglises') }}
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
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewEglise" data-bs-toggle="tooltip" title="Nouvelle Eglise"><i class="fa fa-plus"></i></a>
                <table class="table table-stripped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Adresse</th>
                            <th>District</th>
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
                    <form id="egliseForm" name="egliseForm" class="form-horizontal">
                       <input type="hidden" name="eglise_id" id="eglise_id">
                       <input type="hidden" name="contact_id" id="contact_id">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group mt-2" id="DistSelect">
                            <select class="form-select mt-1" aria-label="Default select example" id="district_id" name="district_id">
                                <option selected value="">Choisir le district</option>
                                @forelse ($districts as $dist)
                                    <option value="{{$dist->id}}">{{$dist->nomDist}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group mt-1" id="typeSelect">

                            <select class="form-select mt-2 mb-2" aria-label="Default select example" id="type_id" name="type_id">
                                <option selected value="">Choisir le type</option>
                                @forelse ($types as $type)
                                    <option value="{{$type->id}}">{{$type->libelleType}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomEglise" class="col-sm control-label">Nom de l' eglise:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomEglise" name="nomEglise" value="" maxlength="50" required>
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

    <div class="modal fade" id="membreModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingDist"></h4>
                </div>
                <div class="modal-body">
                    <form id="membreEgliseForm" name="membreEgliseForm" class="form-horizontal">
                       <input type="hidden" name="eglise_id" id="eglise_id_dist">
                       @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group">
                            <label for="nomEglise" class="col-sm control-label">Nom de l' eglise:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomEgliseDist" name="nomEglise" value="" maxlength="50" disabled>
                            </div>
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
                            <input class="form-check-input" type="radio" name="sexe" id="sexe0" value="0" checked>
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
                    <p class="nomDist"><strong>District:</strong> <span class="district_id"></span></p>
                    <p class="libelleType"><strong>Type:</strong> <span class="type_id"></span></p>
                
                    <p><strong>Nom de l' eglise:</strong> <span class="nomEglise"></span></p>
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
                    <input type="hidden" name="eglise_id" id="eglise_id">
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
            ajax: "{{ route('eglise.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nomEglise', name: 'nomEglise'},
                {data: 'libelleType', name: 'libelleType'},
                {data: 'adresse', name: 'adresse'},
                {data: 'nomDist', name: 'nomDist'},
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
        $('#createNewEglise').click(function () {
            $('#saveBtn').val("create-eglise");
            $('#eglise_id').val('');
            $('#egliseForm').trigger("reset");
            $('#modelHeading').html(" Créer une nouvelle Eglise");
            $('#ajaxModel').modal('show');
        });

        $('#ajaxModel').on('hidden.bs.modal', function () {
            $('.print-error-msg').hide();
        })
        $('#membreModel').on('hidden.bs.modal', function () {
            $('.print-error-msg').hide();
        })
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.showEglise', function () {
          var eglise_id = $(this).data('id');
          $.get("{{ route('eglise.index') }}" +'/' + eglise_id, function (data) {
            
            if (data.district) {
                $('.nomDist').show();
                  $('.district_id').text(data.district.nomDist);
                }
              if (data.type) {
                $('.libelleType').show();
                  $('.type_id').text(data.type.libelleType);
                }
            $('.nomEglise').text(data.nomEglise);
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
        $('body').on('click', '.addMembre', function () {
          var eglise_id = $(this).data('id');
          $.get("{{ route('eglise.index') }}" +'/' + eglise_id +'/addMembre', function (data) {
              $('#modelHeadingDist').html(" Ajouter un membre à cette Eglise");
              $('#saveBtnDist').val("add-membre-eglise");
              $('#membreModel').modal('show');
              $('#eglise_id_dist').val(data.id);
              $('#nomEgliseDist').val(data.nomEglise);
          })
        });
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editEglise', function () {
          var eglise_id = $(this).data('id');
          $.get("{{ route('eglise.index') }}" +'/' + eglise_id +'/edit', function (data) {
              $('#modelHeading').html(" Modifier la Eglise");
              $('#saveBtn').val("edit-eglise");
              $('#ajaxModel').modal('show');
              $('#eglise_id').val(data.id);
              if (data.district) {
                  $('#district_id').val(data.district.id);
                }
              if (data.type) {
                  $('#type_id').val(data.type.id);
                }
              $('#contact_id').val(data.contact.id);
              $('#nomEglise').val(data.nomEglise);
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
        Create eglise Code
        --------------------------------------------
        --------------------------------------------*/
        $('#egliseForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('eglise.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#egliseForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          msg = 'Eglise ajoutée avec succès.';
                          if($('#saveBtn').val() == 'edit-eglise'){
                            msg = 'Eglise modifiée avec succès.';
                          }
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#egliseForm').find(".print-error-msg").find("ul").html('');
                        $('#egliseForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#egliseForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });
        /*------------------------------------------
        --------------------------------------------
        Create membre - eglise Code
        --------------------------------------------
        --------------------------------------------*/
        $('#membreEgliseForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);
            
            $('#saveBtnDist').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('eglise.storeMembre') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtnDist').html('Enregistrer');
                          $('#membreEgliseForm').trigger("reset");
                          $('#membreModel').modal('hide');
                          msg = 'Membre ajouté à cette eglise avec succès.';
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtnDist').html('Enregistrer');
                        $('#membreEgliseForm').find(".print-error-msg").find("ul").html('');
                        $('#membreEgliseForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#membreEgliseForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });

        /*------------------------------------------
        --------------------------------------------
        Delete eglise Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteEglise', function () {
            var eglise_id = $(this).data("id");
            $("#eglise_id").val(eglise_id);
            $('#deleteText').text("Vous voulez vraiment supprimer cette eglise?");
            $('#deleteModel').modal('show');
        });
        $('body').on('click', '#deleteBtn', function () {
            var eglise_id = $("#eglise_id").val();

            $.ajax({
                type: "DELETE",
                url: "{{ route('eglise.store') }}"+'/'+eglise_id,
                success: function (data) {
                    $('#deleteModel').modal('hide');
                    $(".alert-success-text").text('Eglise supprimée avec succès.');
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
