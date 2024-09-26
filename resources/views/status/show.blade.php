<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statuts') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            
            <x-section-border />

            <div class="mt-10 sm:mt-0 cd__main">
                <a class="btn btn-primary mb-1" href="javascript:void(0)" id="createNewStatus"> Nouveau statut</a>
                <table class="table table-stripped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Libellé</th>
                            <th>Date de création</th>
                            <th>Dernière modification</th>
                            <th width="280px">Actions</th>
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
                    <form id="statusForm" name="statusForm" class="form-horizontal">
                       <input type="hidden" name="status_id" id="status_id">
                       @csrf
    
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
    
                        <div class="form-group">
                            <label for="libelleStat" class="col-sm-2 control-label">Libellé du statut:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="libelleStat" name="libelleStat" value="" maxlength="50">
                            </div>
                        </div>
            
                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"><i class="fa fa-save"></i> Enregistrer
                         </button>
                        </div>
                    </form>
                </div>
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
                    <p><strong>Name:</strong> <span class="show-libelleStat"></span></p>
                    <p><strong>Detail:</strong> <span class="show-detail"></span></p>
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
            ajax: "{{ route('status.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'libelleStat', name: 'libelleStat'},
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
        $('#createNewStatus').click(function () {
            $('#saveBtn').val("create-status");
            $('#status_id').val('');
            $('#statusForm').trigger("reset");
            $('#modelHeading').html(" Créer un nouveau Statut");
            $('#ajaxModel').modal('show');
        });
    
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.showStatus', function () {
          var status_id = $(this).data('id');
          $.get("{{ route('status.index') }}" +'/' + status_id, function (data) {
              $('#showModel').modal('show');
              $('.show-libelleStat').text(data.libelleStat);
          })
        });
          
        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editStatus', function () {
          var status_id = $(this).data('id');
          $.get("{{ route('status.index') }}" +'/' + status_id +'/edit', function (data) {
              $('#modelHeading').html(" Modifier le Statut");
              $('#saveBtn').val("edit-user");
              $('#ajaxModel').modal('show');
              $('#status_id').val(data.id);
              $('#libelleStat').val(data.libelleStat);
          })
        });
          
        /*------------------------------------------
        --------------------------------------------
        Create Status Code
        --------------------------------------------
        --------------------------------------------*/
        $('#statusForm').submit(function(e) {
            e.preventDefault();
     
            let formData = new FormData(this);
            $('#saveBtn').html('En cours...');
      
            $.ajax({
                    type:'POST',
                    url: "{{ route('status.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                          $('#saveBtn').html('Enregistrer');
                          $('#statusForm').trigger("reset");
                          $('#ajaxModel').modal('hide');
                          table.draw();
                    },
                    error: function(response){
                        $('#saveBtn').html('Enregistrer');
                        $('#statusForm').find(".print-error-msg").find("ul").html('');
                        $('#statusForm').find(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $('#statusForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
               });
          
        });
          
        /*------------------------------------------
        --------------------------------------------
        Delete Status Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteStatus', function () {
         
            var status_id = $(this).data("id");
            confirm("Are You sure want to delete?");
            
            $.ajax({
                type: "DELETE",
                url: "{{ route('status.store') }}"+'/'+status_id,
                success: function (data) {
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
