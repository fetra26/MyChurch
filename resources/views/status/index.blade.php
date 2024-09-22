@extends('layouts.content')
@section('main-content')
<div class="container">
    <h2>
        Statut
    </h2>
    <div class="text-end mb-5">
        <a href="{{ route('status.create') }}" class="btn btn-primary">Nouveau statut</a>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-primary">
                <th>#</th>
                <th>Libellé</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($status as $stat)
                <tr>
                    <td>{{ $stat->id}}</td>
                    <td>{{ $stat->libelleStat }}</td>
                    <td>
                        <a href={{ route('status.edit', ['id' => $stat->id]) }} class="btn btn-primary"> modifier</a>
                        <button class="btn btn-danger" onClick="deleteFunction('{{ $stat->id }}')">Supprimer</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Aucun statut trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@include ('status.modal_delete')
@endsection

@push('js')
<script>
    function deleteFunction(id) {
        document.getElementById('delete_id').value = id;
        $("#modalDelete").modal('show');
    }
</script>
@endpush
