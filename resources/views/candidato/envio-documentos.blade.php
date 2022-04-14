@extends('templates.template-principal')
@section('content')
<div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
    <div class="form-row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow bg-white style_card_container">
                <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                    @if($inscricao->concurso->tipo == \App\Models\Concurso::TIPO_ENUM['substituto'])
                        <h6 class="style_card_container_header_titulo">Etapa - Avaliação de Títulos</h6>
                    @else
                        <h6 class="style_card_container_header_titulo">Etapa - Compatibilidade do Perfil</h6>
                    @endif
                    <h6 class="style_card_container_header_campo_obrigatorio"><span style="color: red; font-weight: bold;">*</span> Campo obrigatório</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form action="{{route('documentos.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($inscricao->concurso->tipo == \App\Models\Concurso::TIPO_ENUM['substituto'])

                                <div class="form-row">
                                    <div class="form-group col-md-1s2">
                                        <h6 style="text-align:justify;">
                                            Os documentos devem estar legíveis, devidamente escaneados e em PDF. As versões escaneadas devem
                                            ser enviadas em seis (06) arquivos, com tamanho máximo de cada arquivo: 15MB.
                                        </h6>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="dados_pessoais" class="style_campo_titulo" style="color: black; font-weight: bolder;"><span style="color: red; font-weight: bold;">*</span> Documentos Pessoais</label>
                                        @if($arquivos && $arquivos->dados_pessoais) <a href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Dados-pessoais"])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                        <h6 class="style_subtitulo_documento" style="color: black">
                                            <ul>
                                                <li>Carteira de Identidade ou do Documento de Identidade Profissional (Conselhos de Classes) ou da Carteira Nacional de Habilitação – CNH.</li>
                                                <li>Cópia autenticada do Passaporte ou de Cédula de Identidade de Estrangeiro, caso o candidato seja estrangeiro.</li>
                                                <li>Cartão do Cadastro de Pessoa Física - CPF (dispensado para o candidato estrangeiro).</li>
                                                <li>Certidão de quitação eleitoral (emitida pelo site do TRE ou cartório eleitoral).</li>
                                                <li>Documento comprobatório da quitação com serviço militar, para os candidatos do sexo masculino a partir de 1º dia de janeiro
                                                    do ano em completar 18 (dezoito) anos de idade até 31 de dezembro do ano em que completar 45 (quarenta e cinco) anos.
                                                </li>
                                                <li>Documento oficial que comprove que o candidato não possui antecedentes criminais.</li>
                                                <li>Comprovante do pagamento da taxa de inscrição.</li>
                                                <li>Documento que comprove a formação na área/matéria conforme Edital Específico.
                                                    A formação acadêmica pode ser comprovada através de cópias de documentos como: i) Certificado de Graduação e/ou
                                                    Mestrado e/ou Doutorado conforme exigência para a vaga, emitido pela Instituição de Ensino Superior;
                                                    ii) OU diploma de Graduação E/OU Mestrado E/OU Doutorado conforme exigência para a vaga,
                                                    emitido pela Instituição de Ensino Superior.
                                                </li>
                                                <li>Histórico Escolar em que se verifique que o candidato cursou a disciplina objeto da seleção OU
                                                    disciplina(s) equivalente(s) à matéria objeto da seleção.
                                                </li>
                                                <li>Declaração de Veracidade documental.</li>
                                            </ul>
                                        </h6>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('dados_pessoais') is-invalid @enderror"
                                            id="dados_pessoais" name="dados_pessoais" @if(!$arquivos) required @endif/>
                                        @error('dados_pessoais')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if($arquivos && $arquivos->dados_pessoais)<small><strong>Obs:</strong> Caso queira substituir o arquivo enviado por outro, basta anexá-lo novamente.</small>@endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="curriculum_vitae_lattes" class="style_campo_titulo" style="color: black; font-weight: bolder;"><span style="color: red; font-weight: bold;">*</span> Curriculum vitae modelo Lattes</label>
                                        @if($arquivos && $arquivos->curriculum_vitae_lattes) <a href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Lattes"])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                        <h6 class="style_subtitulo_documento" style="color: black">
                                            <ul>
                                                <li>Cópia do Curriculum Vitae modelo Lattes com as devidas comprovações.
                                                    Essas comprovações devem ser enviadas pelos arquivos abaixo.
                                                </li>
                                            </ul>
                                        </h6>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('curriculum_vitae_lattes') is-invalid @enderror" id="curriculum_vitae_lattes"
                                            name="curriculum_vitae_lattes" @if(!$arquivos) required @endif/>
                                        @error('curriculum_vitae_lattes')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if($arquivos && $arquivos->curriculum_vitae_lattes)<small><strong>Obs:</strong> Caso queira substituir o arquivo enviado por outro, basta anexá-lo novamente.</small>@endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="style_campo_titulo" style="color: black; font-weight: bolder;">Documentos a serem pontuados na tabela de avaliação de títulos</label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="formacao_academica" class="style_campo_titulo" style="color: black; font-weight: bolder;"><span style="color: red; font-weight: bold;">*</span> Grupo I - Formação Acadêmica</label>
                                        @if($arquivos && $arquivos->formacao_academica) <a href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Formacao-academica"])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                        <h6 class="style_subtitulo_documento" style="color: black">
                                            <ul>
                                                <li>Graduação.</li>
                                                <li>Especialização.</li>
                                                <li>Mestrado.</li>
                                                <li>Doutorado em Programa reconhecido pelo CNE e credenciado pela CAPES.</li>
                                            </ul>
                                        </h6>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('formacao_academica') is-invalid @enderror"
                                            id="formacao_academica" name="formacao_academica" @if(!$arquivos) required @endif/>
                                        @error('formacao_academica')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if($arquivos && $arquivos->formacao_academica)<small><strong>Obs:</strong> Caso queira substituir o arquivo enviado por outro, basta anexá-lo novamente.</small>@endif
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="experiencia_didatica" class="style_campo_titulo" style="color: black; font-weight: bolder;">Grupo II - Experiência Didática</label>
                                        @if($arquivos && $arquivos->experiencia_didatica) <a href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Experiencia-didatica"])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                        <h6 class="style_subtitulo_documento" style="color: black">
                                            <ul>
                                                <li>Tempo de exercício.</li>
                                                <li>Tempo de exercício como professor no Magistério Superior em Cursos a Distância.</li>
                                                <li>Participação em Bancas ou Comissões Examinadoras de Graduação e Pós-Graduação.</li>
                                                <li>Participação em Bancas ou Comissões Examinadoras de Seleção para o Magistério Superior.</li>
                                                <li>Orientação de Trabalhos Acadêmicos.</li>
                                                <li>Cursos ministrados (Extensão, Capacitação ou equivalentes na área da Seleção) / Para cada 10 horas.</li>
                                            </ul>
                                        </h6>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('experiencia_didatica') is-invalid @enderror"
                                            id="experiencia_didatica" name="experiencia_didatica"/>
                                        @error('experiencia_didatica')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if($arquivos && $arquivos->experiencia_didatica)<small><strong>Obs:</strong> Caso queira substituir o arquivo enviado por outro, basta anexá-lo novamente.</small>@endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="producao_cientifica" class="style_campo_titulo" style="color: black; font-weight: bolder;">Grupo III - Produção Científica</label>
                                        @if($arquivos && $arquivos->producao_cientifica) <a href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Producao-cientifica"])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                        <h6 class="style_subtitulo_documento" style="color: black">
                                            <ul>
                                                <li>Livros publicados.</li>
                                                <li>Capítulos de Livros publicados.</li>
                                                <li>Trabalhos publicados em Revistas e/ou periódicos de reconhecido valor científico ou cultural.</li>
                                                <li>Publicação de Livro Didático ou Material Didático na área da seleção com ISBN.</li>
                                                <li>Desenvolvimento de patentes com registro definitivo (carta patente).</li>
                                            </ul>
                                        </h6>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('producao_cientifica') is-invalid @enderror"
                                            id="producao_cientifica" name="producao_cientifica"/>
                                        @error('producao_cientifica')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if($arquivos && $arquivos->producao_cientifica)<small><strong>Obs:</strong> Caso queira substituir o arquivo enviado por outro, basta anexá-lo novamente.</small>@endif
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="experiencia_profissional" class="style_campo_titulo" style="color: black; font-weight: bolder;">Grupo IV - Experiência Profissional</label>
                                        @if($arquivos && $arquivos->experiencia_profissional) <a href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Experiencia-profissional"])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                        <h6 class="style_subtitulo_documento" style="color: black">
                                            <ul>
                                                <li>Exercício de cargo ou função de Administração Acadêmica.</li>
                                                <li>Prêmios e Láureas acadêmicas.</li>
                                                <li>Bolsas de Pesquisa financiadas por Órgãos de Fomento (exceto Bolsas de Formação).</li>
                                                <li>Exercício Profissional extrauniversitário, com vínculo empregatício, em área relacionada à matéria da seleção.</li>
                                                <li>Consultorias relacionadas ao setor de estudos da Seleção.</li>
                                                <li>Projetos de pesquisa aprovados por Órgãos de Fomento.</li>
                                            </ul>
                                        </h6>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('experiencia_profissional') is-invalid @enderror"
                                            id="experiencia_profissional" name="experiencia_profissional"/>
                                        @error('experiencia_profissional')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if($arquivos && $arquivos->experiencia_profissional)<small><strong>Obs:</strong> Caso queira substituir o arquivo enviado por outro, basta anexá-lo novamente.</small>@endif
                                    </div>
                                </div>
                            @else
                                <div class="form-row">
                                    <div class="form-group col-md-1s2">
                                        <h6 style="text-align:justify;">
                                            O documento deve estar legível, devidamente escaneado e em PDF. A versão escaneada deve
                                            ser enviada em um (1) arquivo, com tamanho máximo de 15MB.
                                        </h6>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="avaliacao_perfil" class="style_campo_titulo" style="color: black; font-weight: bolder;"><span style="color: red; font-weight: bold;">*</span> Anexar Documentos:</label>
                                        @if($arquivos && $arquivos->avaliacao_perfil) <a href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Avaliacao-perfil"])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                        <h6 class="style_subtitulo_documento" style="color: black">
                                            <ul>
                                                <li>Cópias de documentos que comprovem a Compatibilidade do Perfil referente à(s) área(s)/subáreas à(s) qual(is) está concorrendo (Edital das Condições Gerais - item 6.2.1).</li>
                                            </ul>
                                        </h6>
                                        <input type="file" accept=".pdf" class="form-control style_campo @error('avaliacao_perfil') is-invalid @enderror"
                                            id="avaliacao_perfil" name="avaliacao_perfil" @if(!$arquivos) required @endif/>
                                        @error('avaliacao_perfil')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if($arquivos && $arquivos->avaliacao_perfil)<small><strong>Obs:</strong> Caso queira substituir o arquivo enviado por outro, basta anexá-lo novamente.</small>@endif
                                    </div>
                                </div>
                            @endif
                            <input type="hidden" id="inscricao" name="inscricao" value="{{$inscricao->id}}"/>
                            <div><hr></div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-6 form-group" style="margin-bottom: 4px;">
                                    @if (auth()->user()->role == "chefeSetorConcursos" || auth()->user()->role == "admin")
                                        <button type="submit" class="btn btn-success shadow-sm" style="width: 100%;" id="submeterFormBotao">
                                            Enviar
                                        </button>
                                    @elseif(auth()->user()->role == "candidato")
                                        @if ($inscricao->concurso->data_inicio_envio_doc <= date('Y-m-d', strtotime(now())) && date('Y-m-d', strtotime(now())) <= $inscricao->concurso->data_fim_envio_doc)
                                            <button type="submit" class="btn btn-success shadow-sm" style="width: 100%;" id="submeterFormBotao">
                                                Enviar
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("input").change(function(){
        const fileSize = this.files[0].size / 1024 / 1024;
        if(fileSize > 15){
            alert("O arquivo deve ter no máximo 15MB!");
            this.value = "";
        };
    });
</script>
@endsection
