@extends('templates.template-principal')
@section('content')
    <div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow bg-white style_card_container">
                    <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                        <div class="form-group">
                            <h6 class="style_card_container_header_titulo">Editar concurso</h6>
                            <h6 class="" style="font-weight: normal; color: #909090; margin-top: -10px; margin-bottom: -15px;">Meus concursos > Editar concurso</h6>
                        </div>
                        <h6 class="style_card_container_header_campo_obrigatorio"><span style="color: red; font-weight: bold;">*</span> Campo obrigatório</h6></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <h6 style="color: #707070; font-weight: normal; font-size: 22px;">Informações</h6>
                            </div>
                            @error('error')
                                <div class="alert alert-danger">
                                    {{$menssage}}
                                </div>
                            @enderror
                            <form method="POST" action="{{route('concurso.update', ['concurso' => $concurso->id])}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label for="titulo" class="style_campo_titulo">Título <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="text" class="form-control style_campo @error('título') is-invalid @enderror" id="titulo" name="título" placeholder="Concurso de professores substitutos 2021.1" value="{{old('título') != null ? old('título') : $concurso->titulo}}">

                                        @error('título')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label for="tipo" class="style_campo_titulo">{{__('Tipo do concurso')}}<span style="color: red; font-weight: bold;">*</span></label>
                                        <select name="tipo" id="tipo" class="form-control style_campo @error('tipo') is-invalid @enderror" required>
                                            <option selected disabled value="">-- Selecione o tipo do concurso --</option>
                                            @if (old('tipo') != null)
                                                <option @if(old('tipo') == $tipos['efetivo']) selected @endif value="{{$tipos['efetivo']}}">Efetivo</option>
                                                <option @if(old('tipo') == $tipos['substituto']) selected @endif value="{{$tipos['substituto']}}">Substituto</option>
                                            @else
                                                <option @if($concurso->tipo == $tipos['efetivo']) selected @endif value="{{$tipos['efetivo']}}">Efetivo</option>
                                                <option @if($concurso->tipo == $tipos['substituto']) selected @endif value="{{$tipos['substituto']}}">Substituto</option>
                                            @endif
                                        </select>
    
                                        @error('tipo')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="quantidade_vagas" class="style_campo_titulo">Quantidade vagas <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="number" class="form-control style_campo @error('quantidade_de_vagas') is-invalid @enderror" id="quantidade_vagas" name="quantidade_de_vagas" placeholder="5" value="{{old('quantidade_de_vagas') != null ? old('quantidade_de_vagas') : $concurso->qtd_vagas}}">

                                        @error('quantidade_de_vagas')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="card shadow bg-white style_card_container">
                                            <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                                                <h6 class="style_card_container_header_titulo">Áreas do concurso</h6>
                                                <button type="button" id="btn-adicionar-escolhar" onclick="adicionarEscolha()" class="btn btn-primary" style="margin-top:10px;">Adicionar área</button>
                                            </div>
                                            <div class="card-body">
                                                <div id="opcoes" class="row">
                                                    @if(old('opcoes_vaga') != null)
                                                        @foreach (old('opcoes_vaga') as $i => $opcao)
                                                            <div class="col-sm-5 form-group" style="border: 1px solid #ced4da; border-radius: 10px; padding: 20px; margin-left: 35px; margin-right: 25px;">
                                                                <label class="style_campo_titulo">Nome da área <span style="color: red; font-weight: bold;">*</span></label>
                                                                <input type="hidden" name="opcoes_id[]" value="{{old('opcoes_id.'.$i)}}">
                                                                <input class="form-control style_campo @error('opcoes_vaga.'.$i) is-invalid @enderror" type="text" placeholder="Professor de geografia" name="opcoes_vaga[]" value="{{$opcao}}">

                                                                @error('opcoes_vaga.'.$i)
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror

                                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Excluir</button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        @foreach ($concurso->vagas as $i => $opcao)
                                                            <div class="col-sm-5 form-group" style="border: 1px solid #ced4da; border-radius: 10px; padding: 20px; margin-left: 35px; margin-right: 25px;">
                                                                <label class="style_campo_titulo">Nome da área <span style="color: red; font-weight: bold;">*</span></label>
                                                                <input type="hidden" name="opcoes_id[]" value="{{$opcao->id}}">
                                                                <input class="form-control style_campo @error('opcoes_vaga.'.$i) is-invalid @enderror" type="text" placeholder="Professor de geografia" name="opcoes_vaga[]" value="{{$opcao->nome}}">

                                                                @error('opcoes_vaga.'.$i)
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror

                                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Excluir</button>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="descricao" class="style_campo_titulo">Descrição <span style="color: red; font-weight: bold;">*</span></label>
                                        <textarea type="text" class="form-control style_campo @error('descrição') is-invalid @enderror" id="descricao" name="descrição" placeholder="Esse concurso se refere há..." rows="5" cols="30">{{old('descrição') != null ? old('descrição') : $concurso->descricao}}</textarea>

                                        @error('descrição')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="data_inicio_inscricao" class="style_campo_titulo">Data de início das inscrições <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="date" class="form-control style_campo @error('data_de_início_da_inscrição') is-invalid @enderror" id="data_inicio_inscricao" name="data_de_início_da_inscrição" value="{{old('data_de_início_da_inscrição') != null ? old('data_de_início_da_inscrição') : $concurso->data_inicio_inscricao}}">

                                        @error('data_de_início_da_inscrição')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="data_fim_inscricao" class="style_campo_titulo">Data de término das inscrições <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="date" class="form-control style_campo @error('data_de_término_da_inscrição') is-invalid @enderror" id="data_fim_inscricao" name="data_de_término_da_inscrição" value="{{old('data_de_término_da_inscrição') != null ? old('data_de_término_da_inscrição') : $concurso->data_fim_inscricao}}">

                                        @error('data_de_término_da_inscrição')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="data_fim_isencao_inscricao" class="style_campo_titulo">Data limite para isenção <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="date" class="form-control style_campo @error('data_limite_para_isenção') is-invalid @enderror" id="data_fim_isencao_inscricao" name="data_limite_para_isenção" value="{{old('data_limite_para_isenção') != null ? old('data_limite_para_isenção') : $concurso->data_fim_isencao_inscricao}}">

                                        @error('data_limite_para_isenção')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="data_fim_pagamento_inscricao" class="style_campo_titulo">Data limite para pagamento <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="date" class="form-control style_campo @error('data_limite_para_pagamento') is-invalid @enderror" id="data_fim_pagamento_inscricao" name="data_limite_para_pagamento" value="{{old('data_limite_para_pagamento') != null ? old('data_limite_para_pagamento') : $concurso->data_fim_pagamento_inscricao}}">

                                        @error('data_limite_para_pagamento')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="data_inicio_envio_doc" class="style_campo_titulo">Data início para envio dos documentos <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="date" class="form-control style_campo @error('data_de_início_para_envio_dos_documentos') is-invalid @enderror" id="data_inicio_envio_doc" name="data_de_início_para_envio_dos_documentos" value="{{old('data_de_início_para_envio_dos_documentos') != null ? old('data_de_início_para_envio_dos_documentos') : $concurso->data_inicio_envio_doc}}">

                                        @error('data_de_início_para_envio_dos_documentos')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="data_fim_envio_doc" class="style_campo_titulo">Data fim para envio dos documentos <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="date" class="form-control style_campo @error('data_final_para_envio_dos_documentos') is-invalid @enderror" id="data_fim_envio_doc" name="data_final_para_envio_dos_documentos" value="{{old('data_final_para_envio_dos_documentos') != null ? old('data_final_para_envio_dos_documentos') : $concurso->data_fim_envio_doc}}">

                                        @error('data_final_para_envio_dos_documentos')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="data_resultado_selecao" class="style_campo_titulo">Data do resultado do concurso <span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="date" class="form-control style_campo @error('data_do_resultado_do_concurso') is-invalid @enderror" id="data_resultado_selecao" name="data_do_resultado_do_concurso" value="{{old('data_do_resultado_do_concurso') != null ? old('data_do_resultado_do_concurso') : $concurso->data_resultado_selecao}}">

                                        @error('data_do_resultado_do_concurso')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">

                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="edital_geral" class="style_campo_titulo">Edital geral <span style="color: red; font-weight: bold;">*</span> &nbsp;</label><a href="{{asset('storage/' . $concurso->edital_geral)}}" target="_black">Arquivo atual</a>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('edital_geral') is-invalid @enderror" name="edital_geral" id="edital_geral" value="{{old('edital_geral')}}">
                                        <small>Para editar o arquivo envie um novo</small>
                                        @error('edital_geral')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="edital_especifico" class="style_campo_titulo">Edital específico <span style="color: red; font-weight: bold;">*</span> &nbsp;</label><a href="{{asset('storage/' . $concurso->edital_especifico)}}" target="_black">Arquivo atual</a>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('edital_específico') is-invalid @enderror" name="edital_específico" id="edital_especifico" value="{{old('edital_específico')}}">
                                        <small>Para editar o arquivo envie um novo</small>
                                        @error('edital_específico')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <label for="declaracao_de_veracidade" class="style_campo_titulo">Declaração de veracidade <span style="color: red; font-weight: bold;">*</span> &nbsp;</label><a href="{{asset('storage/' . $concurso->declaracao_veracidade)}}" target="_black">Arquivo atual</a>
                                        <input type="file" accept=".pdf, .docx" class="form-control style_campo @error('declaração_de_veracidade') is-invalid @enderror" name="declaração_de_veracidade" id="declaracao_de_veracidade" value="{{old('declaração_de_veracidade')}}">
                                        <small>Para editar o arquivo envie um novo</small>
                                        @error('declaração_de_veracidade')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="card shadow bg-white style_card_container">
                                            <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                                                <h6 class="style_card_container_header_titulo">Documentos extras</h6>
                                                <button type="button" id="btn-adicionar-escolhar" onclick="addDoc()" class="btn btn-primary" style="margin-top:10px;">Adicionar documento</button>
                                            </div>
                                            <div class="card-body">
                                                <div id="docs" class="row">
                                                    @if(old('docsExtras') != null)
                                                        <input type="hidden" id="docs_indice" value="{{count(old('docsExtras'))-1}}">
                                                        @foreach (old('docsExtras') as $i => $doc)
                                                            <div class="col-sm-5 form-group" style="border: 1px solid #ced4da; border-radius: 10px; padding: 20px; margin-left: 35px; margin-right: 25px;">
                                                                <label class="style_campo_titulo">Nome do documento</label>
                                                                <input class="form-control style_campo @error('docsExtras.*') is-invalid @enderror" type="text" name="docsExtras[]" value="{{$doc}}"><a href="{{route('docExtra.anexo', ['doc' => $doc])}}" target="_black">Arquivo atual</a>

                                                                @error('docsExtras.*')
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <input type="file" accept=".pdf" name="arquivos[]" id="file-input-" class="form-control style_campo @error('arquivos.*') is-invalid @enderror">
                                                                @error('arquivos.*')
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Excluir</button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <input type="hidden" id="docs_indice" value="{{$concurso->documentosExtras->count()-1}}">
                                                        @foreach ($concurso->documentosExtras as $i => $doc)
                                                            <div class="col-sm-5 form-group" style="border: 1px solid #ced4da; border-radius: 10px; padding: 20px; margin-left: 35px; margin-right: 25px;">
                                                                <input type="hidden" name="docsID[]" value="{{$doc->id}}">
                                                                <label class="style_campo_titulo">Nome do documento <span style="color: red; font-weight: bold;">*</span></label>
                                                                <input class="form-control style_campo @error('docsExtras.*') is-invalid @enderror" type="text" name="docsExtras[]" value="{{$doc->nome}}"><a href="{{route('docExtra.anexo', ['doc' => $doc])}}" target="_black">Arquivo atual</a>

                                                                @error('docsExtras.*')
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <input type="file" accept=".pdf" name="arquivos[]" id="file-input-" class="form-control style_campo @error('arquivos.*') is-invalid @enderror">
                                                                @error('arquivos.*')
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Excluir</button>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-bottom: 5px;">
                                    <hr>
                                </div>
                                <div class="col-md-12" style="margin-bottom: 5px; text-align: right;">
                                    <button type="submit" class="btn btn-success shadow-sm" style="width: 240px; ">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function adicionarEscolha() {
            var escolha = `<div class="col-sm-5" style="border: 1px solid #ced4da; border-radius: 10px; padding: 20px; margin-left: 35px; margin-right: 25px;">
                            <label>Nome da área <span style="color: red; font-weight: bold;">*</span></label>
                            <input type="hidden" name="opcoes_id[]" value="0">
                            <input class="form-control" type="text" placeholder="Professor de geografia" name="opcoes_vaga[]">
                            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger">Excluir</button>
                           </div>`;
            $('#opcoes').append(escolha);
        }

        function addDoc() {
            var indice = document.getElementById("docs_indice");
            var doc_indice = parseInt(document.getElementById("docs_indice").value)+1;
            indice.value = doc_indice;

            var doc = `<div class="col-sm-5 form-group" style="border: 1px solid #ced4da; border-radius: 10px; padding: 20px; margin-left: 35px; margin-right: 25px;">
                            <label class="style_campo_titulo">Nome do documento <span style="color: red; font-weight: bold;">*</span></label>
                            <input class="form-control style_campo @error('docsExtras.*') is-invalid @enderror" type="text" name="docsExtras[]" required>

                            @error('docsExtras.*')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label class="style_campo_titulo">Anexo <span style="color: red; font-weight: bold;">*</span></label>
                            <input type="file" accept=".pdf" name="arquivos[]" id="file-input-`+doc_indice+`" required class="form-control style_campo @error('arquivos.*') is-invalid @enderror">
                            @error('arquivos.*')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Excluir</button>
                        </div>`;
            $('#docs').append(doc);
        }
    </script>
@endsection
