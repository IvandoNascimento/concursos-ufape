@extends('templates.template-principal')
@section('content')
<div class="container" style="margin-top: 2rem">
    <div class="row justify-content-center">
        <div class="container" style="margin-bottom: 1rem;">
          @if(!Auth::check())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong> A inscrição em um concurso só é possível apenas quando cadastrado no sistema. </strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          @if($inscricao)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong> Você já realizou uma inscrição nesse concurso.</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
        </div>
        <div class="col-md-7" style="margin-bottom:10px">
          <div class="form-row">
            <div class="col-md-12" style="margin-bottom:20px">
              <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
                @if(isset($concurso->fotoconcurso))
                  <img src="{{asset('storage/concursos/'.$concurso->id.'/logo.png')}}" class="card-img-top" alt="...">
                @else
                  <img src="{{asset('img/img_fundo_2.png')}}" class="card-img-top" alt="..." style="border-radius:12px">
                @endif
                  <div class="card-body">
                      <div class="form-row">

                        <div class="col-md-12" style="margin-bottom: 1.5rem">
                          <h5 class="card-title mb-0" style="font-size:35px; font-family:Arial, Helvetica, sans-serif; color:#0842A0; font-weight:bold">{{$concurso->titulo}}</h5>
                        </div>

                        <div class="col-md-12" style="margin-top: 5px">
                          <div><h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6;">Descrição</h5></div>
                          <div style="margin-top: 10px"><textarea id="descricao-concurso" disabled>{{$concurso->descricao}}</textarea></div>
                        </div>
                        {{-- <div class="col-md-12" style="margin-top: 5px">
                          <div><h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6;">Avisos</h5></div>
                          <div id="editor" style="border:none;"></div>
                        </div> --}}
                      </div>
                  </div>
              </div>
            </div>
          </div>
          @if($notas_aviso->count() > 0)
            <div class="form-row">
              <div class="col-md-12" style="margin-bottom:20px">
                <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
                    <div class="card-body">
                        <div class="form-row">
                          <div class="col-md-12" style="margin-bottom: 0.5rem">
                            <h4 class="card-title mb-0" style="font-family:Arial, Helvetica, sans-serif; color:#0842A0; font-weight:bold">Avisos</h4>
                          </div>

                          @foreach ($notas_aviso as $nota)
                            <div class="col-md-12" style="margin-top: 5px">
                              <div id="nota-{{$nota->id}}" style="margin-top: 10px"></div>
                            </div>
                          @endforeach
                          {{-- <div class="col-md-12" style="margin-top: 5px">
                            <div><h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6;">Avisos</h5></div>
                            <div id="editor" style="border:none;"></div>
                          </div> --}}
                        </div>
                    </div>
                </div>
              </div>
            </div>
          @endif
          @if($notas_notificacao->count() > 0)
            <div class="form-row">
              <div class="col-md-12" style="margin-bottom:20px">
                <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
                    <div class="card-body">
                        <div class="form-row">
                          <div class="col-md-12" style="margin-bottom: 0.5rem">
                            <h4 class="card-title mb-0" style="font-family:Arial, Helvetica, sans-serif; color:#0842A0; font-weight:bold">Notificações</h4>
                          </div>

                          @foreach ($notas_notificacao as $nota)
                            <div class="col-md-12" style="margin-top: 5px">
                              <div id="nota-{{$nota->id}}" style="margin-top: 10px"></div>
                            </div>
                          @endforeach
                          {{-- <div class="col-md-12" style="margin-top: 5px">
                            <div><h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6;">Avisos</h5></div>
                            <div id="editor" style="border:none;"></div>
                          </div> --}}
                        </div>
                    </div>
                </div>
              </div>
            </div>
          @endif
        </div>
        <div class="col-md-4">
            <div class="form-row">
                <div class="col-md-12" style="margin-bottom:30px">
                    <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                        <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                            <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                                <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Ações</h5>
                              </div>
                        </div>
                        <div class="card-body">
                          <div class="form-row">
                            @if($concurso->data_inicio_inscricao <= date('Y-m-d', strtotime(now())) && date('Y-m-d', strtotime(now())) <= $concurso->data_fim_inscricao)
                                @if (!$inscricao)
                                  <div class="col-md-12" style="margin-bottom:18px">
                                      <button class="btn btn-success " onclick ="location.href='{{ route('inscricao.concurso', $concurso->id) }}'"
                                          style="width:100%; height:50px; padding-top:7px; font-size:20px">
                                          <img src="{{asset('img/icon_enviar_proposta.png')}}" class="card-img-top" alt="..." style="width:30px; margin-right:5px">Realizar inscrição
                                      </button>
                                  </div>
                                @endif
                            @endif
                            <div class="col-md-12 btn-group">
                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%; height:50px; padding-top:7px; font-size:20px">
                                <img src="{{asset('img/icon_compartilhar.svg')}}" class="card-img-top" alt="dropdown-compartilhar" style="width:30px; margin-right:5px">Compartilhar
                              </button>
                              <div class="dropdown-menu" style="width: 97%">
                                <a class="dropdown-item" onclick="shareWhatsapp('{{route('concurso.show', ['concurso' => $concurso->id])}}')">
                                  <img src="{{asset('img/whatsapp.svg')}}" class="card-img-top" alt="whatsapp" style="width:30px; margin-right:5px">Whatsapp
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick="shareFacebook('{{route('concurso.show', ['concurso' => $concurso->id])}}')">
                                  <img src="{{asset('img/facebook.png')}}" class="card-img-top" alt="facebook" style="width:30px; margin-right:5px">Facebook
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick="shareTwitter('{{route('concurso.show', ['concurso' => $concurso->id])}}')">
                                  <img src="{{asset('img/twitter.png')}}" class="card-img-top" alt="twitter" style="width:30px; margin-right:5px">Twitter
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom:30px">
                    <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                        <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                            <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                              <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Datas importantes</h5>
                            </div>
                        </div>
                        <div class="card-body">
                          <div class="form-row">

                            <div class="col-md-12">
                              <div class="d-flex justify-content-left align-items-center">
                                <div style="margin-right:10px; margin-top:-20px">
                                  <img class="" src="{{asset('img/icon_submissao.png')}}" alt="" width="40px">
                                </div>
                                  <div class="form-group">
                                    <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Inscrições entre</h5></div>
                                    <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($concurso->data_inicio_inscricao))}} - {{date('d/m/Y',strtotime($concurso->data_fim_inscricao))}}</h5></div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="d-flex justify-content-left align-items-center">
                                <div style="margin-right:10px; margin-top:-20px">
                                  <img class="" src="{{asset('img/isencao_pagamento.png')}}" alt="" width="40px">
                                </div>
                                  <div class="form-group">
                                    <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Solicitar a isenção de inscrição até</h5></div>
                                    <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($concurso->data_fim_isencao_inscricao))}}</h5></div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="d-flex justify-content-left align-items-center">
                                <div style="margin-right:10px; margin-top:-20px">
                                  <img class="" src="{{asset('img/pagamento.png')}}" alt="" width="40px">
                                </div>
                                  <div class="form-group">
                                    <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Pagamento de inscrição até</h5></div>
                                    <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($concurso->data_fim_pagamento_inscricao))}}</h5></div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="d-flex justify-content-left align-items-center">
                                <div style="margin-right:10px; margin-top:-20px">
                                  <img class="" src="{{asset('img/icon_recurso.png')}}" alt="" width="40px">
                                </div>
                                  <div class="form-group">
                                    <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Envio de documentos entre</h5></div>
                                    <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($concurso->data_inicio_envio_doc))}} - {{date('d/m/Y',strtotime($concurso->data_fim_envio_doc))}}</h5></div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom: -15px">
                              <div class="d-flex justify-content-left align-items-center">
                                <div style="margin-right:10px; margin-top:-20px">
                                  <img class="" src="{{asset('img/icon_resultado_final.png')}}" alt="" width="40px">
                                </div>
                                  <div class="form-group">
                                    <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Resultado Parcial</h5></div>
                                    <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($concurso->data_resultado_selecao))}}</h5></div>
                                  </div>
                              </div>
                            </div>

                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom:30px">
                  <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                      <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                            <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Documentos</h5>
                          </div>
                      </div>
                      <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                @if($concurso->edital_geral != null)
                                    <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                        <div style="margin-right:10px; margin-top:-15px">
                                            <img class="" src="{{asset('img/icon_modelo.png')}}" alt="" width="40px">
                                        </div>
                                        <div class="form-group" style="width: 100%">
                                            <div class="d-flex justify-content-between" style="width: 100%">
                                                <div><h5 style=" font-size:19px; margin-top:9px">Edital<br>geral</h5></div>
                                                <div>
                                                    <a class="btn btn-light" href="{{asset('storage/'.$concurso->edital_geral)}}" target="_new" style="" >
                                                    <img class="" src="{{asset('img/file-download-solid.svg')}}" style="width:20px"><br>
                                                    Baixar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <h6 style="color: #909090">O criador do concurso não disponibilizou o edital geral</h6>
                                @endif
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="col-md-12">
                                @if($concurso->edital_especifico != null)
                                    <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                        <div style="margin-right:10px; margin-top:-15px">
                                            <img class="" src="{{asset('img/icon_edital.png')}}" alt="" width="40px">
                                        </div>
                                        <div class="form-group" style="width: 100%">
                                            <div class="d-flex justify-content-between" style="width: 100%">
                                                <div><h5 style=" font-size:19px; margin-top:9px">Edital<br>especifico</h5></div>
                                                <div style="float: right">
                                                  <a class="btn btn-light" href="{{asset('storage/'.$concurso->edital_especifico)}}" target="_new" style="" >
                                                      <img class="" src="{{asset('img/file-download-solid.svg')}}" style="width:20px"><br>
                                                      Baixar
                                                  </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <h6 style="color: #909090">O criador do concurso não disponibilizou o edital especifico</h6>
                                @endif
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="col-md-12">
                                @if($concurso->declaracao_veracidade != null)
                                        <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                            <div style="margin-right:10px; margin-top:-15px">
                                                <img class="" src="{{asset('img/icon_edital.png')}}" alt="" width="40px">
                                            </div>
                                            <div class="form-group" style="width: 100%">
                                                <div class="d-flex justify-content-between" style="width: 100%">
                                                    <div><h5 style=" font-size:19px; margin-top:9px">Documento de <br>veracidade</h5></div>
                                                <div style="float: right"><a class="btn btn-light" href="{{asset('storage/'.$concurso->declaracao_veracidade)}}" target="_new" style="" >
                                                    <img class="" src="{{asset('img/file-download-solid.svg')}}" style="width:20px"><br>
                                                    Baixar</a>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                @else
                                    <h6 style="color: #909090">O criador do concurso não disponibilizou o documento de veracidade</h6>
                                @endif
                            </div>
                            @php
                                $cores = ['rgb(84, 172, 255)', 'rgb(255, 104, 84)', 'rgb(207, 159, 0)']
                            @endphp
                            @foreach ($concurso->documentosExtras as $i => $doc)
                              @if($i < 2)
                                <div class="col-md-12"><hr></div>
                                
                                <div class="col-md-12">
                                  <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                        <div style="margin-right:10px; margin-top:-15px">
                                            <img style="border:7px solid {{$cores[$i%3]}}; border-radius: 50%;"  class="" src="{{asset('img/icon_edital_fill.png')}}" alt="" width="40px">
                                        </div>
                                        <div class="form-group" style="width: 100%">
                                            <div class="d-flex justify-content-between" style="width: 100%">
                                                <div><h5 style=" font-size:19px; margin-top:20px">{{$doc->nome}}</h5></div>
                                                <div style="float: right">
                                                  <a class="btn btn-light" href="{{route('docExtra.anexo', ['doc' => $doc])}}" target="_new" style="" >
                                                      <img class="" src="{{asset('img/file-download-solid.svg')}}" style="width:20px"><br>
                                                      Baixar
                                                  </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              @endif
                            @endforeach

                            @if($concurso->documentosExtras->count() >= 3)
                                    
                              @foreach ($concurso->documentosExtras as $i => $doc)
                                @if($i >= 2)
                                  <div class="col-md-12"><hr></div>
                                  
                                  <div class="col-md-12">
                                    <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                          <div style="margin-right:10px; margin-top:-15px">
                                              <img style="border:7px solid {{$cores[$i%3]}}; border-radius: 50%;"  class="" src="{{asset('img/icon_edital_fill.png')}}" alt="" width="40px">
                                          </div>
                                          <div class="form-group" style="width: 100%">
                                              <div class="d-flex justify-content-between" style="width: 100%">
                                                  <div><h5 style=" font-size:19px; margin-top:20px">{{$doc->nome}}</h5></div>
                                                  <div style="float: right">
                                                    <a class="btn btn-light" href="{{route('docExtra.anexo', ['doc' => $doc])}}" target="_new" style="" >
                                                        <img class="" src="{{asset('img/file-download-solid.svg')}}" style="width:20px"><br>
                                                        Baixar
                                                    </a>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                @endif
                              @endforeach
                              {{--<div class="row">
                                <div class="col-md-6" style="text-align: right">
                                </div>
                                <div class="col-md-6">
                                  <a id="resultadosBoxDocs" onclick="alterarMenosDocs()" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo">
                                    Mostrar mais
                                  </a>
                                  <input type="hidden" id="resultadoFlagDocs" value="0">
                                </div>
                              </div>--}}
                            @endif
                        </div>
                    </div>
                </div>
                </div>
                {{-- @if($notas_resultado->count() > 0) --}}
                  <div class="col-md-12" style="margin-bottom:30px">
                    <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                        <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                            <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                              <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Resultados</h5>
                            </div>
                        </div>
                        <div class="card-body">
                          {{--
                              <div class="col-md-12">
                                  <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                      <div class="form-group" style="width: 100%">
                                          <div class="d-flex justify-content-between" style="width: 100%">
                                              <div>
                                                {{-- @foreach ($notas_resultado as $nota)
                                                  <div class="col-md-12" id="nota-{{$nota->id}}"></div>
                                                @endforeach 
                                                <h5 style=" font-size:19px; margin-top:9px">Para acesso aos resultados do concurso, acesse o portal da UFAPE, na seção Concursos / Professor do magistério superior. Endereço:
                                                  <a target="_black" href="http://ufape.edu.br/br/professor-magist%C3%A9rio-superior-concurso">http://ufape.edu.br/br/professor-magist%C3%A9rio-superior-concurso</a>
                                                </h5>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>--}}
                              @forelse($concurso->resultados as $i => $resultado)
                                @if($i < 5)
                                  <div class="col-md-12">
                                        <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                            <div style="margin-right:10px; margin-top:-20px">
                                                <img class="" src="{{asset('img/file-pdf-solid.svg')}}" alt="" width="20px">
                                            </div>
                                            <div class="form-group" style="width: 100%">
                                                <div class="d-flex justify-content-between" style="width: 100%">
                                                    <div><a style=" font-size:19px; margin-top:9px" href="{{route('resultados.anexo', ['resultado' => $resultado])}}" target="_new">{{$resultado->nome}}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  @endif
                              @empty
                                {{--<h6 style="color: #909090">Não há resultados publicados para o concurso</h6>--}}
                                <div class="col-md-12">
                                  <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                      <div class="form-group" style="width: 100%">
                                          <div class="d-flex justify-content-between" style="width: 100%">
                                              <div>
                                                <h5 style=" font-size:19px; margin-top:9px">Para acesso aos resultados do concurso, acesse o portal da UFAPE, na seção Concursos / Professor do magistério superior. Endereço:
                                                  <a target="_black" href="http://ufape.edu.br/br/professor-magist%C3%A9rio-superior-concurso">http://ufape.edu.br/br/professor-magist%C3%A9rio-superior-concurso</a>
                                                </h5>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              @endforelse

                              @if($concurso->resultados->count() > 5)
                                <div class="accordion" id="accordionExample">
                                  
                                  <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                      @foreach ($concurso->resultados as $i => $resultado)
                                        @if($i >= 5)
                                          <div class="col-md-12">
                                              <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                                                  <div style="margin-right:10px; margin-top:-20px">
                                                      <img class="" src="{{asset('img/file-pdf-solid.svg')}}" alt="" width="20px">
                                                  </div>
                                                  <div class="form-group" style="width: 100%">
                                                      <div class="d-flex justify-content-between" style="width: 100%">
                                                          <div><a style=" font-size:19px; margin-top:9px" href="{{route('resultados.anexo', ['resultado' => $resultado])}}" target="_new">{{$resultado->nome}}</a></div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                        @endif
                                      @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6" style="text-align: right">
                                  </div>
                                  <div class="col-md-6">
                                    <a id="resultadosBox" onclick="alterarMenos()" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne">
                                      Mostrar mais
                                    </a>
                                    <input type="hidden" id="resultadoFlag" value="0">
                                  </div>
                                </div>
                              @endif
                          </div>
                      </div>
                  </div>
                {{-- @endif --}}
            </div>
          </div>
        </div>
    </div>
  </div>
  <script scr="{{asset('ckeditor/ckeditor.js')}}"></script>
  <script>
    function shareWhatsapp(url) {
      window.open("https://api.whatsapp.com/send?text="+url, "Compartilhar com o facebook", "height=1000,width=1000");
    }
    function shareFacebook(url) {
      window.open("https://www.facebook.com/sharer/sharer.php?u="+url, "Compartilhar com o facebook", "height=1000,width=1000");
    }
    function shareTwitter(url) {
      window.open("https://twitter.com/intent/tweet?url="+url, "Compartilhar com o facebook", "height=1000,width=1000");
    }

    function alterarMenos() {
      resultadoFlag = document.getElementById('resultadoFlag').value;
      box = document.getElementById('resultadosBox');
      if(resultadoFlag == 0){
        box.innerHTML = "Mostrar menos";
        document.getElementById('resultadoFlag').value = 1;
      }else{
        box.innerHTML = "Mostrar mais";
        document.getElementById('resultadoFlag').value = 0;
      }
    }

    function alterarMenosDocs() {
      resultadoFlag = document.getElementById('resultadoFlagDocs').value;
      box = document.getElementById('resultadosBoxDocs');
      if(resultadoFlag == 0){
        box.innerHTML = "Mostrar menos";
        document.getElementById('resultadoFlagDocs').value = 1;
      }else{
        box.innerHTML = "Mostrar mais";
        document.getElementById('resultadoFlagDocs').value = 0;
      }
    }

    $(document).ready(function() {
      var textarea = document.getElementById('descricao-concurso');
      // console.log(textarea.scrollHeight);
      textarea.style.height = textarea.scrollHeight + "px";

      $.ajax({
        url: "{{route('notas.get')}}",
        method: 'get',
        type: 'get',
        data: {
            concurso_id: "{{$concurso->id}}",
        },
        success: function(data){
          // console.log(data[.length]);
          if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              try {
                var divNota = document.getElementById('nota-'+data[i].id);
                divNota.innerHTML = data[i].texto;
                divNota.style.backgroundColor = data[i].cor;
                if (data[i].anexo != null) {
                  divNota.append(criarTagA(data[i].id));
                }
                if (data[i].tipo == 3) {
                  divNota.style.borderRadius = "5px";
                  divNota.style.padding = "0px";
                  divNota.style.margin = "0px";
                } else {
                  divNota.style.borderRadius = "5px";
                  divNota.style.padding = "10px";
                  divNota.style.margin = "3px";
                }
              } catch (error) {
                console.log(error);
              }
            }
          }
        },
      });
    });

    function criarTagA(id){
      var a = document.createElement("a");
      a.href = "{{url('/')}}/notas/"+id+"/anexo";
      a.class = "btn btn-success";
      a.textContent = "Anexo";
      a.onmouseover = mudarFundoEscuro(a);
      a.onmouseout = mudarFundoNormal(a);
      a.target = "_black";
      a.style.display = "inline-block";
      a.style.color = "#fff";
      a.style.textAlign = "center";
      a.style.verticalAlign = "middle";
      a.style.webkitUserSelect = "none";
      a.style.msUserSelect = "none";
      a.style.userSelect = "none";
      a.style.backgroundColor = "#28A745";
      a.style.border = "1px solid #28A745";
      a.style.padding = "0.375rem 0.75rem";
      a.style.fontSize = "1rem";
      a.style.lineHeight = "1rem";
      a.style.borderRadius = "0.25rem";
      a.style.transition = "color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;";
      a.style.textDecoration = "none";
      return a;
    }

    function mudarFundoEscuro(a) {
      a.style.backgroundColor = "#218838";
      a.style.border = "1px solid #1e7e34";
    }

    function mudarFundoNormal(a) {
      a.style.backgroundColor = "#28A745";
      a.style.border = "1px solid #28A745";
    }
  </script>
@endsection
