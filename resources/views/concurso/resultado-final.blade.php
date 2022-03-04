@extends('templates.template-principal')
@section('content')
    <div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow bg-white style_card_container">
                    <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                        <h6 class="style_card_container_header_titulo">Resultado Parcial</h6>
                    </div>
                    @if($avaliacoesConcurso->first() != null && $avaliacoesConcurso->first()->count() > 0)
                        @foreach ($avaliacoesConcurso as $avaliacoes)
                        <div class="card-body">
                            <table class="table table-bordered table-hover tabela_container">
                                <thead>
                                    <tr>
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Posição</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 50%;">Nome</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 50%;">Vaga</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Nota</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Ficha de avaliação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($avaliacoes as $avaliacao)
                                        <tr>
                                            <th scope="row" id="tabela_container_linha" style="text-align: center; vertical-align: middle;">{{$cont}}</th>
                                            <td id="tabela_container_linha" style="text-align: center; vertical-align: middle;">{{ $avaliacao->inscricao->user->nome }}</td>
                                            <td id="tabela_container_linha" style="text-align: center; vertical-align: middle;">{{ $avaliacao->inscricao->vaga->nome }}</td>
                                            <td id="tabela_container_linha" style="text-align: center; vertical-align: middle;">
                                                {{ $avaliacao->nota }}
                                            </td>
                                            <td id="tabela_container_linha" style="text-align: center; vertical-align: middle;">
                                                <a class="btn btn-primary" href="{{route('visualizar.ficha-avaliacao', $avaliacao->id)}}" target="_new">
                                                    <div class="btn-group">
                                                        <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                        <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @php
                                        $cont = $cont +1;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    @else
                        <div class="card-body">
                            <div class="form-row" style="text-align: center;">
                                <div class="col-md-12" style="margin-top: 5rem; margin-bottom: 10rem;">
                                    <img src="{{asset('img/img_default_meus_etapas.svg')}}" alt="Imagem default" width="190px">
                                    <h6 class="style_campo_titulo" style="margin-top: 20px;">Resultado parcial ainda não está disponível.</h6>
                                </div>
                            </div>
                        </div>
                    @endif    
                </div>
            </div>
        </div>
    </div>
@endsection