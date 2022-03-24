@extends('templates.template-principal')
@section('content')
    <div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow bg-white style_card_container">
                    <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                        <div class="form-group">
                            <h6 class="style_card_container_header_titulo">Resultados publicados em {{$concurso->titulo}}</h6>
                            <h6 class="" style="font-weight: normal; color: #909090; margin-top: -10px; margin-bottom: -15px;">Meus concursos > Resultados publicados</h6>
                        </div>
                        <h6 class="style_card_container_header_campo_obrigatorio"><a href="{{route('resultados.create', ['concurso' => $concurso->id])}}" class="btn btn-primary" style="margin-top:10px;">Publicar resultado</a></h6>
                    </div>

                    @if($resultados->count() > 0)
                        <div class="card-body">
                            @if(session('success'))
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 5px;">
                                        <div class="alert alert-success" role="alert">
                                            <p>{{session('success')}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @error('error')
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 5px;">
                                        <div class="alert alert-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </div>
                                    </div>
                                </div>
                            @enderror
                            <table class="table table-hover table-responsive-sm">
                                <thead>
                                    <tr class="shadow-sm" style="border: 1px solid #dee2e6">
                                        <th scope="col" class="tabela_container_cabecalho_titulo">#</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Nome</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($resultados as $resultado)
                                        <tr>
                                            <th scope="row" style="text-align: center;">
                                                {{$cont}}
                                            </th>
                                            <td>
                                                <div style="margin-bottom: -3px">
                                                    <a target="_black" href="{{route('resultados.anexo', ['resultado' => $resultado])}}">
                                                        <img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;">
                                                        {{$resultado->nome}}
                                                    </a>
                                                </div>
                                                <div class="form-group">
                                                    <div><h6 style="font-weight: normal; color:#909090; font-style: italic; font-size:15px">Publicado no dia: {{$resultado->created_at->format('d/m/Y')}}</h6></div>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <div style="margin-right: 10px">
                                                        <a class="btn btn-info shadow-sm" href="{{route('resultados.edit', ['resultado' => $resultado, 'concurso' => $concurso])}}"><img src="{{asset('img/icon_editar.svg')}}" alt="Editar resultado {{$resultado->nome}}" width="16.5px" ></a>
                                                    </div>
                                                    <div style="margin-right: 15px">
                                                        <a class="btn btn-danger shadow-sm" data-toggle="modal" data-target="#deletar-resultado-{{$resultado->id}}" style="cursor:pointer;"><img src="{{asset('img/icon_lixeira.svg')}}" alt="Resultado publicado {{$resultado->nome}}" width="13px" ></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $cont = $cont +1;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer" style="background-color: #fff; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                            <div><h6 style="color: #909090; margin-bottom:1px">Legenda:</h6></div>
                            <div class="form-row">
                                <div class="btn-group" style="margin:5px">
                                    <label style="margin-right: 10px; padding-left:13px;padding-right:13px; border-radius:6px; background-color:#17a2b8;">
                                        <img class="card-img-left example-card-img-responsive" src="{{asset('img/icon_editar.svg')}}" width="15px" style="margin-top: 10px "/>
                                    </label>
                                    <h6>Editar <br>resultado</h6>
                                </div>
                                <div class="btn-group" style="margin: 5px">
                                    <label style="margin-right: 10px; padding-left:13px;padding-right:13px; border-radius:6px; background-color:#dc3545;">
                                        <img class="card-img-left example-card-img-responsive" src="{{asset('img/icon_lixeira.svg')}}" width="12px" style="margin-top: 10px "/>
                                    </label>
                                    <h6>Excluir <br>resultado</h6>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="form-row" style="text-align: center;">
                                <div class="col-md-12" style="margin-top: 5rem; margin-bottom: 10rem;">
                                    <img src="{{asset('img/img_default_meus_concursos.svg')}}" alt="Imagem default" width="190px">
                                    <h6 class="style_campo_titulo" style="margin-top: 20px;">Nenhum resultado publicado.</h6>
                                    <h6 class="style_campo_titulo" style="font-weight: normal;"><a href="{{route('resultados.create', ['concurso' => $concurso->id])}}">Clique aqui</a> para publicar um novo resultado</h6>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @foreach ($resultados as $resultado)
        <div class="modal fade" id="deletar-resultado-{{$resultado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deletar {{$resultado->nome}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-delete-resultado-{{$resultado->id}}" method="POST" action="{{route('resultados.destroy', ['resultado' => $resultado])}}">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            Tem certeza que deseja deletar {{$resultado->nome}}?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger" form="form-delete-resultado-{{$resultado->id}}" id="submeterFormBotao">Deletar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
