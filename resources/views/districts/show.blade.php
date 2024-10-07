<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Districts') }}
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
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewDistrict" data-bs-toggle="tooltip" title="Nouveau District"><i class="fa fa-plus"></i></a>
                <table class="table table-stripped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Federation</th>
                            <th>Mission</th>
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
                    <form id="districtForm" name="districtForm" class="form-horizontal">
                        <input type="hidden" name="district_id" id="district_id">
                        @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group">
                            <label for="nomDist" class="col-sm control-label">Nom du district:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomDist" name="nomDist" value="" maxlength="50">
                            </div>
                        </div>
                        <center class="mt-3">

                            <button type="button" id="toggleFed" class="btn btn-primary">Federation</button>

                            Ou <button type="button" id="toggleMiss" class="btn btn-primary">Mission</button>
                        </center>
                        <div class="form-group mt-2" id="fedSelect" style="display:none;">
                            <select class="form-select mt-1" aria-label="Default select example" id="federation_id" name="federation_id">
                                <option selected>Choisir la federation</option>
                                @forelse ($federations as $fed)
                                    <option value="{{$fed->id}}">{{$fed->nomFed}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group mt-1" id="missSelect" style="display:none;">

                            <select class="form-select mt-2" aria-label="Default select example" id="mission_id" name="mission_id">
                                <option selected value="">Choisir la mission</option>
                                @forelse ($missions as $miss)
                                    <option value="{{$miss->id}}">{{$miss->nomMiss}}</option>
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

    <div class="modal fade" id="showModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> Details</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Nom du district:</strong> <span class="nomDist"></span></p>
                    <p><strong>Federation:</strong> <span class="federation_id"></span></p>
                    <p><strong>Mission:</strong> <span class="mission_id"></span></p>
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
                    <input type="hidden" name="district_id" id="district_id">
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
            $('#toggleFed').click(function () {
                // Hide missSelect if it is open
                if ($('#missSelect').is(':visible')) {
                    $('#missSelect').val('');
                    $('#missSelect').slideUp();
                }

                // Toggle fedSelect
                $('#fedSelect').slideToggle();
            });

            $('#toggleMiss').click(function () {
                // Hide fedSelect if it is open
                if ($('#fedSelect').is(':visible')) {
                    $('#fedSelect').val('');
                    $('#fedSelect').slideUp();
                }

                // Toggle missSelect
                $('#missSelect').slideToggle();
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
            ajax: "{{ route('district.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nomDist', name: 'nomDist'},
                {data: 'federation', name: 'federation'},
                {data: 'mission', name: 'mission'},
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
        $('#createNewDistrict').click(function () {
            $('#saveBtn').val("create-district");
            $('#district_id').val('');
            $('#districtForm').trigger("reset");
            $('#modelHeading').html(" Créer un nouveau District");
            $('#ajaxModel').modal('show');
        });
        $('#ajaxModel').on('hidden.bs.modal', function () {
            $('#fedSelect').slideUp();
            $('#missSelect').slideUp();
        })
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.showDistrict', function () {
          var district_id = $(this).data('id');
          $.get("{{ route('district.index') }}" +'/' + district_id, function (data) {


            $('.nomDist').text(data.nomDist);
            $('.federation_id').text(data.contact.federation_id);
            $('.mission_id').text(data.contact.mission_id);
            $('#showModel').modal('show');
          })
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editDistrict', function () {
          var district_id = $(this).data('id');
          $.get("{{ route('district.index') }}" +'/' + district_id +'/edit', function (data) {
              $('#modelHeading').html(" Modifier le District");
              $('#saveBtn').val("edit-district");
              $('#ajaxModel').modal('show');
              $('#district_id').val(data.id);
              $('#nomDist').val(data.nomDist);
              if (data.federation) {
                  $('#federation_id').val(data.federation.id);
                    // Hide missSelect if it is open
                    if ($('#missSelect').is(':visible')) {
                        $('#missSelect').slideUp();
                    }

                    // Toggle fedSelect
                    $('#fedSelect').slideToggle();
              }
              if (data.mission){
                    $('#mission_id').val(data.mission.id);
                    // Hide fedSelect if it is open
                    if ($('#fedSelect').is(':visible')) {
                        $('#fedSelect').slideUp();
                    }

                    // Toggle missSelect
                    $('#missSelect').slideToggle();
              }
          })
        });

        /*------------------------------------------
        --------------------------------------------
        Create district Code
        --------------------------------------------
        --------------------------------------------*/
        $('#districtForm').submit(function(e) {
            e.preventDefault();
            if(!$('#missSelect').is(':visible')){
                console.log($('#missSelect').val());

                $('#missSelect').val('');
            }else if (!$('#fedSelect').is(':visible')) {
                console.log($('#fedSelect').val());
                $('#fedSelect').val('');
            }
            // console.log(this);

            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');

            $.ajax({
                    type:'POST',
                    url: "{{ route('district.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#districtForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          msg = 'District ajouté avec succès.';
                          if($('#saveBtn').val() == 'edit-district'){
                            msg = 'District modifié avec succès.';
                          }
                          $(".alert-success-text").text(msg);
                          $(".alert-success").show();
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#districtForm').find(".print-error-msg").find("ul").html('');
                        $('#districtForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#districtForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });

        });

        /*------------------------------------------
        --------------------------------------------
        Delete district Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteDistrict', function () {
            var district_id = $(this).data("id");
            $("#district_id").val(district_id);
            $('#deleteText').text("Vous voulez vraiment supprimer cette district?");
            $('#deleteModel').modal('show');
        });
        $('body').on('click', '#deleteBtn', function () {
            var district_id = $("#district_id").val();

            $.ajax({
                type: "DELETE",
                url: "{{ route('district.store') }}"+'/'+district_id,
                success: function (data) {
                    $('#deleteModel').modal('hide');
                    $(".alert-success-text").text('District supprimée avec succès.');
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
