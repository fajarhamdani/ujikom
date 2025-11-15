@extends('layouts.app')

@section('title', 'To-Do List')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Create new task --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('to_do_list.store') }}" method="POST" class="row g-2">
                @csrf
                <div class="col-sm-9">
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Tambah Tugas" required>
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-primary w-100" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tasks table --}}
    @php $list = $tasks ?? $todos ?? $items ?? collect(); @endphp

    @if($list->isEmpty())
        <div class="text-muted">Belum ada tugas yang dimasukkan.</div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width:48px;">No</th>
                            <th>Tugas</th>
                            <th style="width:140px;">Status</th>
                            <th style="width:170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $index => $task)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    @if(!empty($task->completed) && $task->completed)
                                        <span class="text-decoration-line-through text-muted">{{ $task->title ?? $task->name ?? 'Untitled' }}</span>
                                    @else
                                        {{ $task->title ?? $task->name ?? 'Untitled' }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if(!empty($task->status) && $task->status)
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Selesai</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex gap-2">
                                        {{-- Toggle complete (uses update route) --}}
                                        <form action="{{ route('to_do_list.update', $task->id) }}" method="POST" class="d-inline" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="0">
                                            <input type="checkbox" name="status" value="1" {{ (!empty($task->status) && $task->status) ? 'checked' : '' }} onchange="this.form.submit()" class="form-check-input">
                                        </form>

                                        {{-- Delete --}}
                                        <form action="{{ route('to_do_list.destroy', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(method_exists($list, 'links'))
                <div class="card-footer">
                    {{ $list->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
