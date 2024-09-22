
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Ajouter un nouveau statut</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                  <form class="add_form" method="post" action="@if (isset($edit->id)) {{ route('status.update', ['id' => $edit->id]) }}@else{{ route('status.store') }} @endif">
                      @csrf
                      <div class="form-group mb-3">
                          <label for="">Libellé</label>
                          <input class="form-control" type="text" id="libelleStat" name="libelleStat" placeholder="Entrer le libellé" value="@if (isset($edit->id)) {{ $edit->name }}@else {{ old('libelleStat') }} @endif">
                          @error('libelleStat')
                          <div class="text-danger">{{ $message }}</div>
                          @enderror
                      </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-modal" value="Submit">Enregistrer</button>
                    </form>
                  <button type="button" class="btn btn-danger btn-modal" data-bs-dismiss="modal">Annuler</button>

            </div>
        </div>
    </div>
</div>
