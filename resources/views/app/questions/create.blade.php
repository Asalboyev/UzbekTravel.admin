@extends('layouts.app')


@section('content')
<!-- HEADER -->
<div class="header">
    <div class="container-fluid">

        <!-- Body -->
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">

                    <!-- Title -->
                    <h1 class="header-title">
                        {{ $title }}
                    </h1>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .header-body -->
        @include('app.components.breadcrumb', [
        'datas' => [
        [
        'active' => false,
        'url' => route($route_name.'.index'),
        'name' => $title,
        'disabled' => false
        ],
        [
        'active' => true,
        'url' => '',
        'name' => 'Добавление',
        'disabled' => true
        ],
        ]
        ])
    </div>
</div> <!-- / .header -->

<!-- CARDS -->
<div class="container-fluid">
    <form method="post" action="{{ route($route_name.'.store') }}" enctype="multipart/form-data" >
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="card mw-50">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach($langs as $lang)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $lang->code }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $lang->code }}" type="button" role="tab" aria-controls="{{ $lang->code }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $lang->title }}</button>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    @foreach($langs as $lang)
                                    <div class="tab-pane mt-3 fade {{ $loop->first ? 'show active' : '' }}" id="{{ $lang->code }}" role="tabpanel" aria-labelledby="{{ $lang->code }}-tab">
                                        <div class="form-group">
                                            <label for="question{{ $lang->code }}" class="form-label {{ $lang->code == $main_lang->code ? 'required' : '' }}">Вопрос</label>
                                            <input type="text" {{ $lang->code == $main_lang->code ? 'required' : '' }} class="form-control @error('question.'.$lang->code) is-invalid @enderror" name="question[{{ $lang->code }}]" value="{{ old('question.'.$lang->code) }}" id="question{{ $lang->code }}" placeholder="Вопрос...">
                                            @error('question.'.$lang->code)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="desc" class="form-label">Answer</label>
                                            <textarea name="answer[{{ $lang->code }}]" id="answer" cols="30" rows="10" class="form-control @error('answer.'.$lang->code) is-invalid @enderror ckeditor" name="answer[{{ $lang->code }}]" placeholder="Answer...">{{ old('desc.'.$lang->code) }}</textarea>

                                            {{--                                                <textarea name="desc[{{ $lang->code }}]" id="editor_{{ $lang->code }}" cols="30" rows="10" class="form-control @error('desc.'.$lang->code) is-invalid @enderror " name="desc[{{ $lang->code }}]" placeholder="Описание...">{{ old('desc.'.$lang->code) }}</textarea>--}}
                                            @error('answer.'.$lang->code)
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="model-btns d-flex justify-content-end">
                            <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
            </div>
        </div>
    </form>
</div>
@endsection


