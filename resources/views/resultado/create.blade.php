@extends('templates.template-principal')
@section('content')
    <div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow bg-white style_card_container">
                    <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                        <div class="form-group">
                            <h6 class="style_card_container_header_titulo">Publicar resultado em {{$concurso->titulo}}</h6>
                            <h6 class="" style="font-weight: normal; color: #909090; margin-top: -10px; margin-bottom: -15px;">Meus concursos > Resultados publicados > Publicar resultado</h6>
                        </div>
                        <h6 class="style_card_container_header_campo_obrigatorio"><span style="color: red; font-weight: bold;">*</span> Campo obrigatório</h6></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <h6 style="color: #707070; font-weight: normal; font-size: 22px;">Informações</h6>
                            </div>
                        </div>
                        <form method="POST" action="{{route('resultados.store', ['concurso' => $concurso])}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="nome" class="style_campo_titulo">Nome <span style="color: red; font-weight: bold;">*</span></label>
                                    <input type="text" class="form-control style_campo @error('nome') is-invalid @enderror" id="nome" name="nome" placeholder="Digite o nome do arquivo" value="{{old('nome')}}" required>

                                    @error('nome')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="arquivo" class="style_campo_titulo">Anexo</label>
                                    <input type="file" accept=".pdf" class="form-control style_campo @error('arquivo') is-invalid @enderror" name="arquivo" id="arquivo" value="{{old('arquivo')}}" required>

                                    @error('arquivo')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 5px;">
                                <hr>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 5px; text-align: right;">
                                <button type="submit" class="btn btn-success shadow-sm" style="width: 240px;" id="submeterFormBotao">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
